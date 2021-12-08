<template lang="">
    <div>
        <form @submit.prevent="submit">
            <div class="relative flex">
                <textarea @keyup.enter="submit" v-model="this.form.content" ref="textarea" aria-label="댓글 달기..." data-testid="post-comment-text-area" placeholder="댓글 달기..." rows="1" class="w-full resize-none border-l-0 border-r-0 border-b-0 border-t-gray-300 focus:outline-0 focus:placeholder-gray-400 text-gray-600 placeholder-gray-600 pr-12 py-3"></textarea>
                <div class="absolute right-0 items-center inset-y-0 hidden sm:flex">
                    <button type="submit" class="inline-flex items-center justify-center rounded-full font-bold	 h-12 w-12 transition duration-500 ease-in-out text-blue-200 hover:text-blue-500 bg-none focus:outline-none">
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
            form: {
                content: null,
                postId: this.postId,
            },
        }
    },
    methods: {
        submit() {
            // this.form.post('/comment/', {
            //     onSuccess: () => {
            //         this.$emit('getCurrentPosts');
            //     }
            // });
            // this.form.reset();

            axios.post('/comment/', this.form)
            .then(response => {
                this.$emit('getCurrentPost', response.data);
                this.form.content = '';
            })
            .catch(error => {
                console.log(error);
            })
        },
        focus() {
            this.$refs.textarea.focus();
        }
    },
}
</script>
<style lang="">

</style>
