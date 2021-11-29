<template lang="">
    <div>
        <span @click="showUserPage(comment.user.id)" class="font-medium mr-2 font-bold cursor-pointer">{{ comment.user.name }}</span> {{ comment.content }}
    </div>
</template>
<script>
export default {
    props: [
        'comment'
    ],
    methods: {
        showUserPage(userId) {
            this.$emit('showUserPage', userId);
        }
    },
}
</script>
<style lang="">

</style>
