<template lang="">
    <div>
        <div v-if="!isMe(chat)" class="flex items-end items-center">
            <div @click="showUserPage(chat.user.id)" class="cursor-pointer rounded-full h-8 w-8 m-3 bg-gray-500 flex items-center justify-center overflow-hidden">
                <img :src="chat.user.profile_photo_url" alt="profilepic">
            </div>
            <span class="p-3 bg-white rounded-3xl border border-gray-200 inline-block">
                {{ chat.content }}
            </span>
        </div>
        <div v-else class="flex items-end justify-end items-center">
            <span class="p-3 bg-gray-200 rounded-3xl inline-block">
                {{ chat.content }}
            </span>
            <div @click="showUserPage(chat.user.id)" class="cursor-pointer rounded-full h-8 w-8 m-3 bg-gray-500 flex items-center justify-center overflow-hidden">
                <img :src="chat.user.profile_photo_url" alt="profilepic">
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: [
        'chat'
    ],
    methods: {
        isMe(chat) {
            if (chat.user.id == this.$page.props.user.id) {
                return true;
            }
            return false;
        },
        showUserPage(userId) {
            this.$inertia.get('/user/'+ userId);
        },
    },
}
</script>
<style lang="">

</style>
