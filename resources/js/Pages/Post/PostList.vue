<template lang="">
    <div id="postBox">
        <div v-for="post in posts.data" :key="post.id" class="w-full lg:w-1/2 md:w-8/12 mx-auto">
            <post-item :post="post" @getPosts="$emit('getPosts')" @getCurrentPosts="$emit('getCurrentPosts')"></post-item>
        </div>
    </div>
</template>
<script>
import PostItem from '@/Pages/Post/PostItem.vue'



export default {
    components: {
        PostItem,
    },
    props: [
        'posts'
    ],
    data() {
        return {
            scroll: null,
        }
    },
    methods: {

    },
    mounted() {
        // window.removeEventListener('scroll', this.scroll());
        const page = document.getElementById('postBox');
        this.scroll = debounce ((e) => {
                // console.log('scrolled');
                // console.log("offsetHeight:", document.documentElement.offsetHeight);
                // console.log("scrollHeight:", page.scrollHeight);
                // console.log("scrollTop:", document.documentElement.scrollTop);
                // console.log("clientHeight:", page.clientHeight);
                // console.log("innerHeight:", window.innerHeight);

                if (page.scrollHeight - (window.innerHeight + document.documentElement.scrollTop) < 50) {
                    console.log('scrolled down');
                    this.$emit('getMorePosts');
                    // this.getMorePosts();
                }
            }, 300);
        window.addEventListener('scroll', this.scroll);
    },
    beforeUnmount() {
        window.removeEventListener('scroll', this.scroll);
    }
}
</script>
<style lang="">

</style>
