<template lang="">
    <div class="relative h-10 m-1">
        <div style="flex border-top:1px solid #e6e6e6;" class="grid grid-cols-12">
            <input class="col-span-10 outline-none p-1" type="text" v-model="message" @keyup.enter="sendChat()" placeholder="message here">

            <button @click="selectPhoto()" class=" bg-gray-500 hover:bg-blue-700 p-1 mt-1 rounded text-white">
                Photo
            </button>
            <button @click="sendChat()" class="bg-gray-500 hover:bg-blue-700 p-1 mt-1 rounded text-white">
                Send
            </button>
            <input type="file" class="hidden" ref="image" @change="updateImagePreview">
        </div>
    </div>
</template>
<script>
export default {
    props: ['channel'],
    data() {
        return {
            message: '',
        }
    },
    methods: {
        sendChat() {
            if (this.message == '' && !this.$refs.image.files[0]) return;

            let data = new FormData();
            if (this.$refs.image.files[0]) {

                data.append('image', this.$refs.image.files[0]);
            }

            if (this.message) {

                data.append('content', this.message);

            }
            let settings = { headers: { 'content-type': 'multipart/form-data' } };
            axios.post('/dm/channel/' + this.channel.id + '/chat', data, settings)
            .then(response => {
                // if(response.status == 201) {
                    this.message = '';
                    this.$refs.image.value = '';
                    this.$emit('updateImagePreview', null);
                    this.$emit('messageSent');
                    console.log('data: ', response.data);
                // }
            })
            .catch(error=>{
                console.log(error);
            })
        },
        selectPhoto() {
            this.$refs.image.click();
        },
        updateImagePreview() {
            const photo = this.$refs.image.files[0];

            if (!photo) return;

            const reader = new FileReader();

            reader.onload = (e) => {
                // this.$parent.imagePreview = e.target.result;
                this.$emit('updateImagePreview', e.target.result);
            };

            reader.readAsDataURL(photo);
        },
    },
}
</script>
<style lang="">

</style>
