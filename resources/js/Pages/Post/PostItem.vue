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
        <button @click="isOpen = !isOpen" class="relative z-10 block rounded-md bg-white p-2 focus:outline-none">
            <svg class="h-5 w-5 text-gray-800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
        <div v-if="isOpen" class="relative right-0 w-32 bg-white rounded-lg py-2 shadow-xl z-20">
            <a @click="deletePost(post.id)" class="block p-2 text-center text-gray-800 hover:bg-indigo-500 hover:text-white">삭제</a>
            <a @click="openEditForm" class="block p-2 text-center text-gray-800 hover:bg-indigo-500 hover:text-white">수정</a>
            <a href="#" class="block p-2 text-center text-gray-800 hover:bg-indigo-500 hover:text-white">포스트 보기</a>
        </div>
    </div>
    <img class="w-full bg-cover" src="https://3.bp.blogspot.com/-Chu20FDi9Ek/WoOD-ehQ29I/AAAAAAAAK7U/mc4CAiTYOY8VzOFzBKdR52aLRiyjqu0MwCLcBGAs/s1600/DSC04596%2B%25282%2529.JPG">
    <div class="px-3 pb-2">
      <div class="pt-2">
        <i class="far fa-heart cursor-pointer"></i>
        <span class="text-sm text-gray-400 font-medium">12 likes</span>
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

  <post-show :show="showPost" :post="post" :max-width="'full'" @closeModal="closeModal"></post-show>
</template>
<script>
import { defineComponent } from 'vue'
import PostShow from '@/Pages/Post/PostShow.vue'
export default defineComponent({
    components: {
        PostShow,
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
            isOpen: false
        }
    },
    methods: {
        submit() {
            this.form.post('/comment/');
            this.form.reset();
        },
        showUserPage(userId) {
            this.$inertia.get('/'+ userId);
        },
        closeModal() {
            this.showPost = false;
        },
        deletePost(postId) {
            this.form.delete('/post/' + postId);
        },
        openEditForm() {
            this.$emit('openEdit', this.post)
        },
    },
})
</script>
<style lang="">
</style>
