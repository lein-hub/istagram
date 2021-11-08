<template lang="">
    <div>
        <div v-for="post in posts" :key="post.id" class="w-full lg:w-8/12 md:w-8/12 mx-auto">
            <post-item :post="post" @openEdit="openEdit"></post-item>
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
        openEdit(post) {
            this.$emit('openEdit', post);
        }
    },
}
</script>
<style lang="">

</style>
