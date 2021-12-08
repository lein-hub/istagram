<template lang="">
    <div class="relative h-10 m-1">
        <div style="border-top:1px solid #e6e6e6;" class="grid grid-cols-6">
            <input class="col-span-5 outline-none p-1" type="text" v-model="message" @keyup.enter="sendChat()" placeholder="message here">
            <button @click="sendChat()" class="place-self-end bg-gray-500 hover:bg-blue-700 p-1 mt-1 rounded text-white">
                Send
            </button>
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
            if (this.message == '') return;
            axios.post('/dm/channel/' + this.channel.id + '/chat', {
                content: this.message,
            })
            .then(response => {
                if(response.status == 201) {
                    this.message = '';
                    console.log('data: ', response.data);

                    this.$emit('messageSent', response.data);
                }
            })
            .catch(error=>{
                console.log(error);
            })
        }
    },
}
</script>
<style lang="">

</style>
