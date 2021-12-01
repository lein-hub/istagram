<template lang="">
    <app-layout>
        <div class="lg:w-9/12 lg:mx-auto mt-5 mx-3">
            <div class="grid grid-cols-3 lg:gap-7 gap-1">
                <div v-for="post in posts" :key="post.id" class="relative h-0 pb-2/3 pt-1/3 cursor-pointer">
                    <img class="absolute inset-0 w-full h-full object-cover" :src="getImages(post.images[0].images)[0]" alt="">
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue'

export default {
    props: [
        'posts',
    ],
    components: {
        AppLayout,
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
