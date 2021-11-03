<template lang="">
    <div>
        <div v-for="post in posts" :key="post.id" class="w-full lg:w-6/12 md:w-6/12 mx-auto">
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
    ]
}
</script>
<style lang="">

</style>
