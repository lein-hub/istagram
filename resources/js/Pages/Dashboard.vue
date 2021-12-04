<template>
    <app-layout title="Dashboard" @formShow="formShow">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>


        <post-list :posts="posts" @getMorePosts="getMorePosts" @getPosts="getPosts"></post-list>

        <create-form :createFormShow="createFormShow" :form="postForm" @createPost="createPost" @closeModal="closeModal"></create-form>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import CreateForm from '@/Pages/Post/CreateForm.vue'
    import PostList from '@/Pages/Post/PostList.vue'

    export default defineComponent({
        components: {
            AppLayout,
            CreateForm,
            PostList
        },
        props: [
            // 'posts',
        ],
        data() {
            return {
                posts: [],
                createFormShow: false,
                postForm: this.$inertia.form({
                    content: null,
                    images: null,
                }),
            }
        },
        methods: {
            formShow() {
                this.createFormShow = true;
            },
            createPost() {
                this.postForm.post('/post', {
                    forceFormData: true,
                    onSuccess: () => {
                        this.closeModal();
                        this.getPosts();
                    },
                });

                // console.log(this.postForm);
                // axios.post('/post', this.postForm)
                //  .then(response=> {
                //      this.posts = response.data;
                // })
            },
            getPosts() {
                axios.get('/getPosts').then(response => {
                    this.posts = response.data;
                    console.log('getPost');
                }).catch(error=> {
                    console.log(error);
                });
            },
            getCurrentPosts() {
                // 나중에 구현합시다.
            },
            closeModal() {
                this.createFormShow = false;
            },
            getMorePosts() {
                if (this.posts.current_page == this.posts.last_page) {
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
