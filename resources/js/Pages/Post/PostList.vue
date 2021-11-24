<template lang="">
    <div>
        <div v-for="post in posts" :key="post.id" class="w-full lg:w-1/2 md:w-8/12 mx-auto">
            <post-item :post="post"></post-item>
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
    methods: {
    },
}
</script>
<style lang="">

</style>
