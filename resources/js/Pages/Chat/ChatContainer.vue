<template lang="">
    <div class="h-96 w-full">
        <div class="h-full p-2 flex flex-col-reverse overflow-scroll">
            <div v-for="(chat, index) in chats" :key="index">
                <chat-item :chat="chat"></chat-item>
            </div>
        </div>
    </div>
</template>
<script>
import ChatItem from './ChatItem.vue'
export default {
    components: {
        ChatItem,
    },
    props: [
        'chats',
    ]
}
</script>
<style lang="">

</style>
