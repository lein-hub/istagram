<template lang="">
    <jet-dialog-modal :show="show" @close="close">
        <template #content>
            <div class="flex" style="height: 90vh">
                <div class="bg-black flex-grow max-w-3xl">
                    <img v-if="images.length < 2" class="object-contain m-auto h-full bg-cover" :src="images[0]">
                    <image-carousel v-else :images="images"></image-carousel>
                </div>
                <div class="w-96">
                    <div class="rounded overflow-hidden border bg-white md:mx-0 lg:mx-0 flex flex-col h-full">
                        <div class="w-auto flex justify-between p-3 border-b border-gray-300">
                            <div class="flex">
                                <profile-photo :user="post.user"></profile-photo>
                                <span @click="showUserPage(post.user.id)" class="cursor-pointer pt-1 ml-2 font-bold text-sm">{{post.user.name}}</span>
                            </div>
                            <!-- <span class="px-2 hover:bg-gray-300 cursor-pointer rounded"><i class="fas fa-ellipsis-h pt-2 text-lg"></i></span> -->
                            <div v-if="isMine" class="relative">
                                <button @click="isOpen = !isOpen" class="relative hover:bg-gray-300 z-10 block rounded-md bg-white p-2 focus:outline-none">
                                    <svg class="h-5 w-5 text-gray-800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div v-if="isOpen" class="absolute right-0 w-32 bg-white rounded-lg py-2 shadow-xl z-20">
                                    <a @click="deletePost(post.id)" class="block p-2 text-center text-gray-800 hover:bg-indigo-500 hover:text-white cursor-pointer">삭제</a>
                                    <a @click="showEdit = true" class="block p-2 text-center text-gray-800 hover:bg-indigo-500 hover:text-white cursor-pointer">수정</a>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 flex-grow overflow-auto">
                            <div class="pt-1">
                                <div class="mb-2 text-sm inline-flex items-center">
                                    <div class="py-2">
                                        <profile-photo :user="post.user"></profile-photo>
                                    </div>
                                    <div>
                                        <span @click="showUserPage(post.user.id)" class="mx-2 font-bold cursor-pointer">{{post.user.name}}</span>
                                        <template v-for="(item, index) in splittedContent" :key="index">
                                            <Link v-if="isHashtag(item)" :href="gethref(item)" class="text-blue-500 cursor-pointer">{{item}}&nbsp;</Link>
                                            <template v-else>{{item}}&nbsp;</template>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="mb-5 text-sm flex items-center" v-for="comment in post.comments" :key="comment.id">
                                    <profile-photo :user="comment.user"></profile-photo>
                                    <span @click="showUserPage(comment.user.id)" class="mx-2 font-bold cursor-pointer">{{ comment.user.name }}</span> {{ comment.content }}
                                    <button v-if="comment.user.id == $page.props.user.id" @click="deleteComment(comment.id)" class="hover:text-red-600 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <div class="flex my-auto">
                                <svg v-if="isLiked" @click="clickUnlike" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-1 cursor-pointer text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                </svg>
                                <svg v-else @click="clickLike" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-1 cursor-pointer hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <svg @click="$refs.commentInput.focus()" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-1 cursor-pointer hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                <svg v-if="!isMine" @click="newChatChannel(post.user.id)" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-1 cursor-pointer hover:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="pt-1">
                                <i class="far fa-heart cursor-pointer"></i>
                                <span v-if="post.votes.length" class="text-sm text-gray-400 font-medium">{{ post.votes.length }} likes</span>
                            </div>
                            <div>
                                <comment-input :postId="post.id" ref="commentInput" @getCurrentPost="getCurrentPost"></comment-input>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <edit-form :show="showEdit" :post="post" @closeEditModal="showEdit = false" :images="images" @getPosts="$emit('getPosts')" :goUser="goUser"></edit-form>
        </template>
    </jet-dialog-modal>
</template>
<script>
import { defineComponent } from 'vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import ProfilePhoto from '@/Components/ProfilePhoto.vue'
import ImageCarousel from '@/Pages/Post/ImageCarousel.vue'
import CommentInput from '@/Pages/Post/CommentInput.vue'
import EditForm from '@/Pages/Post/EditForm.vue'
import { Link } from '@inertiajs/inertia-vue3'

export default defineComponent({
    components: {
        JetDialogModal,
        ImageCarousel,
        ProfilePhoto,
        CommentInput,
        EditForm,
        Link,
    },
    props: [
        'show',
        'propPost',
        'goUser'
    ],
    emits: [
        'closeModal', 'getCurrentPost', 'getPosts'
    ],
    data() {
        return {
            form: this.$inertia.form({
                content: null,
                postId: this.propPost.id
            }),
            post: this.propPost,
            isOpen: false,
            showEdit: false,
        }
    },
    computed: {
        isLiked() {
            for (let key in this.post.votes) {
                if (this.post.votes[key].user_id == this.$page.props.user.id) {
                    return true;
                }
            }
            return false;
        },
        isMine() {
            return this.post.user_id == this.$page.props.user.id;
        },
        images() {
            if (this.post.images.length) {
                let images = JSON.parse(this.post.images[0].images);
                return images;
            }
            return [];
        },
        splittedContent() {
            var content = this.post.content; // html 안에 'content'라는 아이디를 content 라는 변수로 정의한다.

            var splittedArray = content.split(' '); // 공백을 기준으로 문자열을 자른다.

            return splittedArray;
        }
    },
    methods: {
        close() {
            this.$emit('closeModal');
        },
        showUserPage(userId) {
            this.$inertia.get('/user/'+ userId);
        },
        newChatChannel(userId) {
            this.$inertia.form({
                userId: userId,
            }).post('/dm/channel');
        },
        clickLike() {
            axios.post('/vote', {
                postId: this.post.id,
            }).then(response => {
                this.post = response.data;
                this.$emit('getCurrentPost', response.data);
            }).catch(error => {
                console.log(error);
            });
        },
        clickUnlike() {
            axios.put('/vote', {
                postId: this.post.id,
            }).then(response => {
                this.post = response.data;
                this.$emit('getCurrentPost', response.data);
            }).catch(error => {
                console.log(error);
            });
        },
        getCurrentPost(post) {
            this.post = post;
            this.$emit('getCurrentPost', post);
        },
        deletePost(postId) {
            axios.delete('/post/'+postId)
            .then(response =>{
                this.$emit('getPosts');
                this.close();
            })
            .catch(error => {
                console.log(error);
            })
        },
        deleteComment(commentId) {
            axios.delete(`/comment/${this.post.id}/${commentId}`)
            .then(response => {
                this.post = response.data;
                this.$emit('getCurrentPost', response.data);
            })
            .catch(error => {
                console.log(error);
            })
        },
        isHashtag(string) {
            if (string.indexOf('#') == 0) return true;
            return false;
        },
        gethref(string) {

            string = "/hashtag/" + string.replace(/#/g, "");
            return string;
        },
    },
    watch: {
        propPost(val, oldVal) {
            this.post = val;
        }
    },
});
</script>
<style lang="">

</style>
