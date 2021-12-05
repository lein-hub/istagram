<template lang="">
    <div>
        <img @click="showPost = true" class="absolute inset-0 w-full h-full object-cover" :src="getImages(post.images[0].images)[0]" alt="">
        <post-show :show="showPost" :propPost="post" :max-width="'6xl'" @closeModal="showPost = false"></post-show>
    </div>
</template>
<script>
import PostShow from '@/Pages/Post/PostShow.vue'
export default {
    props: [
        'post'
    ],
    components: {
        PostShow,
    },
    computed: {

    },
    data() {
        return {
            showPost: false,
        }
    },
    methods: {
        getImages(data) {
            let images = JSON.parse(data);
            return images;
        }
    },
}
</script>
<style lang="">

</style>
