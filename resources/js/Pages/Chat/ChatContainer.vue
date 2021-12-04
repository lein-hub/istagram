<template lang="">
    <div class="h-96 w-full">
        <div class="h-full p-2 flex flex-col-reverse overflow-auto" id="chatBox">
            <div v-for="chat in chats.data" :key="chat.id">
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
    ],
    data() {
        return {
        }
    },
    methods: {
        // scroll: function() {
        //     const self = this;
        //     window.onscroll = function(ev) {
        //         if ((window.innerHeight + window.scrollY) >= document.body.scrollHeight) {
        //             const chats_links = self.chats.links;
        //             const next = chats_links[chats_links.length - 1];
        //             if (next.url) {
        //                 self.$inertia.visit(next.url, {
        //                     preserveScroll: true,
        //                     preserveState: true,
        //                 });
        //                 self.chats_data.push(...self.chats.data);
        //             }
        //         }
        //     }
        // }
    },
    mounted() {
        const self = this;
        const chatBox = document.getElementById('chatBox');
        chatBox.addEventListener('scroll', debounce ((e) => {
            // console.log("scrollHeight:", chatBox.scrollHeight);
            // console.log("scrollTop:", chatBox.scrollTop);
            // console.log("clientHeight:", chatBox.clientHeight);

            if (chatBox.clientHeight - chatBox.scrollTop == chatBox.scrollHeight) {
                console.log('scrolled up');
                // this.$parent.getMoreChats();
                self.$emit('getMoreChats');
            }
        }, 100));
    },
}
</script>
<style lang="">

</style>
