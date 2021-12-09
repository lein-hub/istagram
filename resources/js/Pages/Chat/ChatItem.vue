<template lang="">
    <div>
        <div v-if="!isMe(chat)">
            <div class="flex items-center">
                <profile-photo :user="chat.user"></profile-photo>
                <span class="p-3 bg-white rounded-3xl border border-gray-200 inline-block">
                    {{ chat.content }}
                </span>
            </div>
            <div v-if="chat.photo" class="flex items-center ml-8">
                <img class="w-2/5 p-3 bg-white rounded-3xl border border-gray-200 inline-block " :src="chat.photo" alt="">
            </div>
        </div>
        <div v-else>
            <div class="flex justify-end items-center">
                <span class="p-3 bg-gray-200 rounded-3xl inline-block">
                    {{ chat.content }}
                </span>
                <profile-photo :user="chat.user"></profile-photo>
            </div>
            <div v-if="chat.photo" class="flex justify-end items-center mr-8">
                <img class="w-2/5 p-3 bg-gray-200 rounded-3xl inline-block " :src="chat.photo" alt="">
            </div>
        </div>
    </div>
</template>
<script>
import ProfilePhoto from '@/Components/ProfilePhoto.vue'
export default {
    props: [
        'chat'
    ],
    components: {
        ProfilePhoto,
    },
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
