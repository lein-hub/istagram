<template lang="">
    <jet-dialog-modal :show="show" @close="close">
        <template #content>
            <div class="flex">
                <div class="bg-black w-full max-w-3xl	 flex flex-col">
                    <img v-if="images.length < 2" class="w-full my-auto bg-cover" :src="imageArray[0]">
                    <div v-else>
                        <image-carousel :images="images"></image-carousel>
                    </div>
                </div>
                <div class="w-96 min-w-max">
                    <div class="rounded overflow-hidden border bg-white md:mx-0 lg:mx-0">
                        <div class="w-auto flex justify-between p-3 border-b border-gray-300">
                            <div class="flex">
                                <div @click="showUserPage(post.user.id)" class="cursor-pointer rounded-full h-8 w-8 bg-gray-500 flex items-center justify-center overflow-hidden">
                                    <img :src="post.user.profile_photo_url" alt="profilepic">
                                </div>
                                <span @click="showUserPage(post.user.id)" class="cursor-pointer pt-1 ml-2 font-bold text-sm">{{post.user.name}}</span>
                            </div>
                            <span class="px-2 hover:bg-gray-300 cursor-pointer rounded"><i class="fas fa-ellipsis-h pt-2 text-lg"></i></span>
                        </div>
                        <div class="p-3 h-full">
                            <div class="mb-2">
                                <div class="mb-5 text-sm flex" v-for="comment in post.comments" :key="comment.id">
                                    <div @click="showUserPage(comment.user.id)" class="cursor-pointer rounded-full h-8 w-8 bg-gray-500 flex items-center mr-3 justify-center overflow-hidden">
                                        <img :src="comment.user.profile_photo_url" alt="profilepic">
                                    </div>
                                    <span @click="showUserPage(comment.user.id)" class="font-medium mr-2 font-bold cursor-pointer">{{ comment.user.name }}</span> {{ comment.content }}
                                </div>
                            </div>
                        </div>
                        <div class="flex bg-pink-200 flex flex-col">
                            <div class="flex my-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="pt-1">
                                <i class="far fa-heart cursor-pointer"></i>
                                <span class="text-sm text-gray-400 font-medium">12 likes</span>
                            </div>
                            <div>
                                <comment-input :postId="post.id"></comment-input>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </jet-dialog-modal>
</template>
<script>
import { defineComponent } from 'vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import ImageCarousel from '@/Pages/Post/ImageCarousel.vue'
import CommentInput from '@/Pages/Post/CommentInput.vue'

export default defineComponent({
    components: {
        JetDialogModal,
        ImageCarousel,
        CommentInput,
    },
    props: [
        'show',
        'post',
    ],
    emits: [
        'closeModal'
    ],
    data() {
        return {
            form: this.$inertia.form({
                content: null,
                postId: this.post.id
            }),
            images: this.$parent.imageArray,
        }
    },
    methods: {
        close() {
            this.$emit('closeModal');
        },
        showUserPage(userId) {
            this.$inertia.get('/'+ userId);
        },
    },
});
</script>
<style lang="">

</style>
