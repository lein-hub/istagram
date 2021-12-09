<template lang="">
    <app-layout>
        <div v-if="isLoading" class="flex h-screen items-center justify-center">
            <img src="/storage/loading.gif" alt="">
        </div>
        <div v-else-if="posts && posts.data.length" class="lg:w-9/12 lg:mx-auto mt-5 mx-3">
            <div class="flex">
                <div class="w-1/3">
                    <button class="block h-40 w-40 rounded-full overflow-hidden m-auto focus:outline-none">
                        <img class="object-cover h-full w-full" :src="getImages(posts.data[0].images[0].images)[0]" alt="">
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
                                    {{ postCount }}
                                </span>
                            </span>
                        </li>
                    </ul>
                </section>
            </div>


            <!-- <div class="grid grid-cols-3 mt-5 lg:gap-7 gap-1">
                <div v-for="post in posts" :key="post.id" class="relative h-0 pb-2/3 pt-1/3 cursor-pointer">
                    <img class="absolute inset-0 w-full h-full object-cover" :src="getImages(post.images[0].images)[0]" alt="">
                </div>
            </div> -->
            <div class="grid grid-cols-3 lg:gap-7 gap-1 mt-5">
                <div v-for="post in posts.data" :key="post.id" class="relative h-0 pb-2/3 pt-1/3 bg-black cursor-pointer">
                    <post-preview :post="post" @getPosts="getPosts"></post-preview>
                </div>
            </div>
            <div v-if="gettingMorePosts" class="h-32 flex justify-center">
                <img src="/storage/loading.gif" alt="">
            </div>
        </div>
        <div v-else>
            <h1>There is no such posts having hashtag name "{{tagname}}"</h1>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import PostPreview from '@/Pages/PostPreview.vue'

export default {
    props: [
        'tagname', 'postCount'
    ],
    components: {
        AppLayout,
        PostPreview,
    },
    data() {
        return {
            posts: [],
            isLoading: false,
            scroll: null,
            gettingMorePosts: false,
        }
    },
    methods: {
        getImages(data) {
            let images = JSON.parse(data);
            return images;
        },
        getPosts() {
            this.isLoading = true,
            axios.get('/hashtag/getPosts/'+this.tagname)
            .then(response => {
                this.posts = response.data;
                this.isLoading = false;
            })
            .catch(error => {
                console.log(error);
            })
        },
        getMorePosts() {
            if (!this.posts.next_page_url || this.gettingMorePosts) {
                return
            }
            this.gettingMorePosts = true;
            axios.get(this.posts.next_page_url, {})
            .then(response => {
                this.posts = {...response.data, 'data': [...this.posts.data, ...response.data.data]};
                this.gettingMorePosts = false;
            })
            .catch(error => {
                console.log(error);
            });
        },
    },
    created() {
        this.getPosts();
    },
    mounted() {
        this.scroll = debounce ((e) => {
                // console.log('scrolled');
                // console.log("offsetHeight:", document.documentElement.offsetHeight);
                // console.log("scrollHeight:", document.documentElement.scrollHeight);
                // console.log("scrollTop:", document.documentElement.scrollTop);
                // console.log("clientHeight:", window.clientHeight);
                // console.log("innerHeight:", window.innerHeight);

                if (document.documentElement.scrollHeight - (window.innerHeight + document.documentElement.scrollTop) < 500) {
                    console.log('scrolled down');
                    // this.$emit('getMorePosts');
                    this.getMorePosts();
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
