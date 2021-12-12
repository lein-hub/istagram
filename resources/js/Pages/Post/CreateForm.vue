<template lang="">
    <jet-dialog-modal :show="createFormShow" @close="close">
        <template #content>
<div>
  <div>
    <div class="mt-5 mx-auto">
      <form @submit.prevent="createPost">
        <div class="shadow sm:rounded-md sm:overflow-hidden">
          <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
            <div>
              <label class="block text-sm font-medium text-gray-700">
                Load photos
              </label>
              <div class="mt-1 flex justify-center border-2 border-gray-300 border-dashed rounded-md">
                <!-- <div class="space-y-1 text-center">
                  <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  <div class="flex text-sm text-gray-600">
                    <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                      <span>Upload a file</span>
                      <input @change="imageChanged" ref="image" multiple="multiple" id="file-upload" name="file-upload" type="file" class="sr-only">
                    </label>
                    <p class="pl-1">or drag and drop</p>
                  </div>
                  <p class="text-xs text-gray-500">
                    PNG, JPG, GIF up to 10MB
                  </p>
                </div> -->
                <image-input ref="images"></image-input>
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
              <!-- <p class="mt-2 text-sm text-gray-500">
                Brief description for your profile. URLs are hyperlinked.
              </p> -->
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
    props: ['createFormShow'],
    emits: [
        'createPost', 'closeModal', 'getPosts'
    ],
    data() {
        return {
            imagePreview: null,
            form: this.$inertia.form({
                content: null,
                images: null,
            }),
        }
    },
    methods: {
        createPost() {
            if (this.$refs.images.files.length) {
                let images = new Array();
                for (let i=0; i < this.$refs.images.files.length; i++) {
                    images.push(this.$refs.images.files[i].file);
                }
                this.form.images = images;
            }
            this.form.post('/post', {
                forceFormData: true,
                onSuccess: () => {
                    this.close();
                    this.$emit('getPosts');
                },
            });
        },
        close() {
            this.$emit('closeModal');
            this.form.content = null;
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
