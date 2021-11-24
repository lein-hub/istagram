<template lang="">
  <div class="rounded overflow-hidden border w-full bg-white mt-5 md:mx-0 lg:mx-0">
    <div class="w-full flex justify-between p-3">
      <div class="flex">
        <div @click="showUserPage(post.user.id)" class="cursor-pointer rounded-full h-8 w-8 bg-gray-500 flex items-center justify-center overflow-hidden">
          <img :src="post.user.profile_photo_url" alt="profilepic">
        </div>
        <span @click="showUserPage(post.user.id)" class="cursor-pointer pt-1 ml-2 font-bold text-sm">{{post.user.name}}</span>
      </div>
      <!-- <span class="px-2 hover:bg-gray-300 cursor-pointer rounded"><i class="fas fa-ellipsis-h pt-2 text-lg"></i></span> -->
        <div class="relative">
            <button @click="isOpen = !isOpen" class="relative z-10 block rounded-md bg-white p-2 focus:outline-none">
                <svg class="h-5 w-5 text-gray-800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
            <div v-if="isOpen" class="absolute right-0 w-32 bg-white rounded-lg py-2 shadow-xl z-20">
                <a @click="deletePost(post.id)" class="block p-2 text-center text-gray-800 hover:bg-indigo-500 hover:text-white cursor-pointer">삭제</a>
                <a @click="showEdit = true" class="block p-2 text-center text-gray-800 hover:bg-indigo-500 hover:text-white cursor-pointer">수정</a>
                <a @click="showPost=true" class="block p-2 text-center text-gray-800 hover:bg-indigo-500 hover:text-white cursor-pointer">포스트 보기</a>
            </div>
        </div>
    </div>
    <!-- <img v-if="post.images.length < 1" class="w-full bg-cover" src="https://3.bp.blogspot.com/-Chu20FDi9Ek/WoOD-ehQ29I/AAAAAAAAK7U/mc4CAiTYOY8VzOFzBKdR52aLRiyjqu0MwCLcBGAs/s1600/DSC04596%2B%25282%2529.JPG"> -->
    <img v-if="imageArray.length < 2" class="w-full bg-cover" :src="imageArray[0]">
    <div v-else>
        <image-carousel :images="imageArray"></image-carousel>
    </div>
    <div class="px-3 pb-2">
        <div class="flex my-auto">
            <svg v-if="isLiked()" @click="clickUnlike" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
            </svg>
            <svg v-else @click="clickLike" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-1 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-1 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-1 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
        </div>
      <div class="pt-2">
        <!-- <i class="far fa-heart cursor-pointer"></i> -->
        <span v-if="post.votes.length" @click="showList = true" class="text-sm text-gray-400 font-medium">{{ post.votes.length }} likes</span>
      </div>
      <div class="pt-1">
        <div class="mb-2 text-sm">
          <span @click="showUserPage(post.user.id)" class="font-medium mr-2 font-bold cursor-pointer">{{post.user.name}}</span> {{ post.content }}
        </div>
      </div>
      <div v-if="post.comments.length > 2" @click="showPost=true" class="text-sm mb-2 text-gray-400 cursor-pointer font-medium">View all {{ post.comments.length }} comments</div>
      <div class="mb-2">
        <div class="mb-2 text-sm" v-for="comment in post.comments.slice(0,2)" :key="comment.id">
          <span @click="showUserPage(comment.user.id)" class="font-medium mr-2 font-bold cursor-pointer">{{ comment.user.name }}</span> {{ comment.content }}
        </div>
      </div>
    </div>
    <comment-input :postId="post.id"></comment-input>
  <post-show :show="showPost" :post="post" :max-width="'6xl'" @closeModal="closeModal"></post-show>
  <user-list :show="showList" :votes="post.votes" @closeListModal="closeListModal" :max-width="'sm'"></user-list>
  <edit-form :show="showEdit" :post="post" @closeEditModal="closeEditModal"></edit-form>
  </div>

</template>
<script>
import { defineComponent } from 'vue'
import PostShow from '@/Pages/Post/PostShow.vue'
import UserList from '@/Pages/Post/UserList.vue'
import ImageCarousel from '@/Pages/Post/ImageCarousel.vue'
import EditForm from '@/Pages/Post/EditForm.vue'
import CommentInput from '@/Pages/Post/CommentInput.vue'
export default defineComponent({
    components: {
        PostShow,
        UserList,
        ImageCarousel,
        EditForm,
        CommentInput,
    },
    props: [
        'post'
    ],
    data() {
        return {
            form: this.$inertia.form({
                content: null,
                postId: this.post.id
            }),
            showPost: false,
            showList: false,
            showEdit: false,
            isOpen: false,
        }
    },
    computed: {
        imageArray() {
            if (this.post.images.length) {
                let images = JSON.parse(this.post.images[0].images);
                return images;
            }
            return [];
        }
    },
    methods: {
        submit() {
            this.form.post('/comment/');
            this.form.reset();
        },
        showUserPage(userId) {
            this.$inertia.get('/user/'+ userId);
        },
        closeModal() {
            this.showPost = false;
        },
        closeListModal() {
            this.showList = false;
        },
        closeEditModal() {
            this.showEdit = false;
        },
        deletePost(postId) {
            this.$inertia.form({
                postId: this.post.id,
            }).delete('/post/' + postId);
        },
        clickLike() {
            this.$inertia.form({
                postId: this.post.id
            }).post('/vote');
        },
        clickUnlike() {
            this.$inertia.form({
                postId: this.post.id
            }).delete('/vote');
        },
        isLiked() {
            for (let key in this.post.votes) {
                if (this.post.votes[key].user_id == this.$page.props.user.id) {
                    return true;
                }
            }
            return false;
        },
    },
})
</script>
<style lang="">
</style>
