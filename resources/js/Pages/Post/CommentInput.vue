<template lang="">
    <div>
        <form @submit.prevent="submit">
            <div class="relative flex">
                <span class="absolute inset-y-0 flex items-center">
                    <button type="button" class="inline-flex items-center justify-center rounded-full h-12 w-12 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                    </svg>
                    </button>
                </span>
                <textarea v-model="this.form.content" aria-label="댓글 달기..." data-testid="post-comment-text-area" placeholder="댓글 달기..." rows="1" class="w-full resize-none border-l-0 border-r-0 border-b-0 border-t-gray-300 focus:outline-0 focus:placeholder-gray-400 text-gray-600 placeholder-gray-600 pl-12 pr-12 py-3"></textarea>
                <div class="absolute right-0 items-center inset-y-0 hidden sm:flex">
                    <button type="submit" class="inline-flex items-center justify-center rounded-full font-bold	 h-12 w-12 transition duration-500 ease-in-out font-bold text-blue-200 hover:text-blue-500 bg-none focus:outline-none">
                    게시
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
export default {
    props: [
        'postId'
    ],
    data() {
        return {
            form: this.$inertia.form({
                content: null,
                postId: this.postId,
            }),
        }
    },
    methods: {
        submit() {
            this.form.post('/comment/');
            this.form.reset();
        }
    },
}
</script>
<style lang="">

</style>
