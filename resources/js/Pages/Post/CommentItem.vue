<template lang="">
    <div class="flex items-center">
        <span @click="$inertia.get('/user/'+ comment.user.id)" class="mr-2 font-bold cursor-pointer">{{ comment.user.name }}</span>{{ comment.content }}
        <button v-if="comment.user.id == $page.props.user.id" @click="deleteComment(comment.id)" class="hover:text-red-600 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</template>
<script>
export default {
    props: [
        'comment', 'postId'
    ],
    methods: {
        deleteComment(commentId) {
            axios.delete(`/comment/${this.postId}/${commentId}`)
            .then(response => {
                this.$emit('getCurrentPost', response.data);
            })
            .catch(error => {
                console.log(error);
            })
        }
    },
}
</script>
<style lang="">

</style>
