<template>
    <app-layout title="Dashboard" @formShow="formShow" @getPosts="getPosts">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>


        <post-list :posts="posts" @getMorePosts="getMorePosts" @getPosts="getPosts"></post-list>


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
            }
        },
        methods: {
            formShow() {
                this.createFormShow = true;
            },
            getPosts() {
                axios.get('/getPosts').then(response => {
                    this.posts = response.data;
                    console.log('this.posts',this.posts);
                    console.log('response.data',response.data);
                    console.log('getPost');
                }).catch(error=> {
                    console.log(error);
                });
            },
            getCurrentPosts() {
                // 나중에 구현합시다.
            },
            getMorePosts() {
                if (!this.posts.next_page_url) {
                    return
                }
                axios.get(this.posts.next_page_url, {}).then(response => {
                    // console.log(response.data);
                    // this.posts = response.data;
                    // this.posts.data = [...this.posts.data, ...response.data.data];
                    this.posts = {...response.data, 'data': [...this.posts.data, ...response.data.data]};
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
