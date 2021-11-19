<template>
    <app-layout title="Dashboard" @formShow="formShow">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <post-list :posts="posts"></post-list>

        <!-- <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <welcome />
                </div>
            </div>
        </div> -->

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
            'posts',
        ],
        data() {
            return {
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
                    onSuccess: this.closeModal(),
                });
            },
            closeModal() {
                this.createFormShow = false;
            },
        },
    })
</script>
