<template>
    <app-layout title="Dashboard" @formShow="formShow" @getPosts="getPosts">
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template> -->

        <div v-if="!isLoading">
            <post-list :posts="posts" @getMorePosts="getMorePosts" @getPosts="getPosts"></post-list>
            <div v-if="gettingMorePosts" class="h-32 flex justify-center">
                <img src="/storage/loading.gif" alt="">
            </div>
        </div>
        <div v-else class="flex h-screen items-center justify-center">
            <img src="/storage/loading.gif" alt="">
        </div>


    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import PostList from '@/Pages/Post/PostList.vue'

    export default defineComponent({
        components: {
            AppLayout,
            PostList
        },
        props: [
            // 'posts',
        ],
        data() {
            return {
                posts: [],
                isLoading: false,
                gettingMorePosts: false,
            }
        },
        methods: {
            formShow() {
                this.createFormShow = true;
            },
            getPosts() {
                this.isLoading = true;
                axios.get('/getPosts').then(response => {
                    this.posts = response.data;
                    console.log('this.posts',this.posts);
                    console.log('response.data',response.data);
                    console.log('getPost');
                    this.isLoading = false;
                }).catch(error=> {
                    console.log(error);
                });
            },
            getCurrentPosts() {
                // 나중에 구현합시다.
            },
            getMorePosts() {
                if (!this.posts.next_page_url || this.gettingMorePosts) {
                    return
                }
                this.gettingMorePosts = true;
                axios.get(this.posts.next_page_url, {}).then(response => {
                    // console.log(response.data);
                    // this.posts = response.data;
                    // this.posts.data = [...this.posts.data, ...response.data.data];
                    this.posts = {...response.data, 'data': [...this.posts.data, ...response.data.data]};
                    this.gettingMorePosts = false;
                }).catch(error => {
                    console.log(error);
                });
                // this.$inertia.get(this.posts.next_page_url, {}, {
                //     preserveScroll:true,
                //     only: ['posts'],
                // });
            },
        },
        mounted() {
            console.log('created');
            this.getPosts();


        }
    })
</script>
