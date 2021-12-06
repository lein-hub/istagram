<template lang="">
    <jet-dialog-modal :show="show" @close="close">
        <template #content>
<div>
  <div>
    <div class="mt-5 mx-auto">
      <form @submit.prevent="updatePost">
        <div class="shadow sm:rounded-md sm:overflow-hidden">
          <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
            <div>
              <label class="block text-sm font-medium text-gray-700">
                Load photos
              </label>
              <div class="mt-1 flex justify-center border-2 border-gray-300 border-dashed rounded-md">
                <image-input ref="images" :uploadedImages='images'></image-input>
              </div>
              <div class="mt-2" v-show="imagePreview">
                <span class="block w-20 h-20 bg-center bg-no-repeat bg-cover rounded-full"
                    :style="'background-image: url(\'' + imagePreview + '\');'">
                </span>
              </div>
            </div>

            <div>
              <label for="about" class="block text-sm font-medium text-gray-700">
                Content
              </label>
              <div class="mt-1">
                <textarea v-model="form.content" id="about" name="about" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Input your content here"></textarea>
              </div>
              <p class="mt-2 text-sm text-gray-500">
                Brief description for your profile. URLs are hyperlinked.
              </p>
            </div>



          </div>
          <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Save
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
        </template>
    </jet-dialog-modal>
</template>
<script>
import { defineComponent } from 'vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import ImageInput from '@/Components/ImageInput.vue'

export default defineComponent({
    components: {
        JetDialogModal,
        ImageInput,
    },
    props: ['show', 'post', 'images', 'goUser'],
    emits: [
        'closeEditModal',
        'getPosts',
    ],
    data() {
        return {
            imagePreview: null,
            form: this.$inertia.form({
                _method: 'PUT',
                images: null,
                uploadedImages: null,
                content: this.post.content,
                postId: this.post.id,
                goUser: false,
            }),
        }
    },
    methods: {
        updatePost() {
            if (this.$refs.images.files.length) {
                let uploadedImages = new Array();
                let images = new Array();
                for (let i=0; i < this.$refs.images.files.length; i++) {
                    if (this.$refs.images.files[i].file) {
                        images.push(this.$refs.images.files[i].file);
                    } else {
                        uploadedImages.push(this.$refs.images.files[i].preview);
                    }
                }
                this.form.uploadedImages = uploadedImages;
                this.form.images = images;
            }
            console.log(this.form);

            if (this.goUser) {
                this.form.goUser = true;
            }

            this.form.post('/post', {
                preserveScroll: true,
                forceFormData: true,
                onSuccess: () => {
                    this.close();
                    this.$emit('getPosts');
                }
            });

            // axios.put('/post', this.form, )
            // .then(response => {
            //     console.log(response);
            //     // this.close();
            //     // this.$emit('getPosts');
            // })
            // .catch(error => {
            //     console.log(error);
            // })
        },
        close() {
            this.$emit('closeEditModal');
        },
        imageChanged() {
            const photo = this.$refs.image.files;
            console.log(photo);

            if (!photo) return;


            for (let i=0; i<photo.length; i++) {
                let reader = new FileReader();

                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL(photo[i]);
            }


            // const formData = new FormData();
            // formData.append('images', e.target.files[0]);
            // console.log(e.target.files[0]);
            // this.form.images = formData;

            // axios.post('/post/images', formData)
            //     .then(response => {
            //         this.form.image = response.data;
            //         console.log(response.data);
            //     })
            //     .catch(error => {
            //         console.log(error);
            //     })

            // Inertia.post('/post/images', formData, {
            //     forceFormData: true,
            // });
        }
    },
});
</script>
<style lang="">

</style>
