<template lang="">
    <app-layout>
        <div class="lg:w-9/12 lg:mx-auto mt-5 mx-3">
            <div class="flex">
                <div class="w-1/3">
                    <button class="block h-40 w-40 rounded-full overflow-hidden m-auto focus:outline-none">
                        <img class="object-cover h-full w-full" :src="getImages(posts[0].images[0].images)[0]" alt="">
                    </button>

                    <!-- <img class="rounded-full mx-auto" :src="thisUser.profile_photo_url" alt=""> -->
                </div>

                <section class="pl-5">
                    <div class="flex my-3">
                        <h2 class="mr-5 text-2xl">
                            #{{ tagname }}
                        </h2>
                    </div>
                    <ul class="flex relative my-3">
                        <li class="mr-5">
                            <span class="">
                                게시물
                                <span class="font-extrabold">
                                    {{ posts.length }}
                                </span>
                            </span>
                        </li>
                    </ul>
                </section>
            </div>


            <div class="grid grid-cols-3 mt-5 lg:gap-7 gap-1">
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
        'posts', 'tagname'
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
