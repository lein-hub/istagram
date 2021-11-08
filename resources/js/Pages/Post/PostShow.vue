<template lang="">
    <jet-dialog-modal :show="show" @close="close">
        <template #content class="m-5 max-h-full">
            <div class="flex">
                <div class="bg-black w-full flex flex-col">
                    <img class="my-auto" src="https://3.bp.blogspot.com/-Chu20FDi9Ek/WoOD-ehQ29I/AAAAAAAAK7U/mc4CAiTYOY8VzOFzBKdR52aLRiyjqu0MwCLcBGAs/s1600/DSC04596%2B%25282%2529.JPG" alt="">
                </div>
                <div class="w-96">
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
                        <div class="px-3 pb-2 mt-3">
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
                            <div class="pt-5">
                                <form @submit.prevent="submit">
                                    <div class="relative flex">
                                        <span class="absolute inset-y-0 flex items-center">
                                            <button type="button" class="inline-flex items-center justify-center rounded-full h-12 w-12 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 text-gray-600">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                                            </svg>
                                            </button>
                                        </span>
                                        <textarea v-model="this.form.content" aria-label="댓글 달기..." data-testid="post-comment-text-area" placeholder="댓글 달기..." rows="1" class="w-full resize-none border-l-0 border-r-0 border-b-0 border-t-gray-300 focus:outline-0 focus:placeholder-gray-400 text-gray-600 placeholder-gray-600 pl-12 pr-12 py-3"></textarea>
                                        <div class="absolute right-0 items-center inset-y-0 hidden sm:flex">
                                            <button type="submit" class="inline-flex items-center justify-center rounded-full font-bold	 h-12 w-12 transition duration-500 ease-in-out font-bold text-blue-200 hover:text-blue-500 bg-none focus:outline-none">
                                            게시
                                            </button>
                                        </div>
                                    </div>
                                </form>
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

export default defineComponent({
    components: {
        JetDialogModal,
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
            })
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
