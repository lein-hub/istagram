<template lang="">
    <app-layout>
        <div v-if="!isLoading" class="lg:w-9/12 lg:mx-auto mt-5 mx-3">
            <div class="flex">
                <div class="w-1/3">
                    <button class="block h-40 w-40 mx-auto border-solid border-6 border-gray-100 rounded-full overflow-hidden focus:outline-none">
                        <img class="object-cover h-full w-full" :src="thisUser.profile_photo_url" alt="">
                    </button>
                </div>
                <section class="w-2/3 pl-5">
                    <div class="flex my-3">
                        <h2 class="mr-5 text-2xl">
                            {{ thisUser.name }}
                        </h2>
                        <div v-if="isMe">
                            <div class="mr-5">
                                <button class="border bg-white rounded mr-5 p-1 font-extrabold" @click="$inertia.get('/user/profile')" tabindex="0">
                                    프로필 편집
                                </button>
                            </div>
                        </div>
                        <div v-else>
                            <div class="mr-5">
                                <a v-if="!isFollowed" class="rounded mr-5 p-1 font-extrabold bg-blue-500 cursor-pointer" @click="clickFollow" tabindex="0">
                                    팔로우 하기
                                </a>
                                <a v-else class="rounded mr-5 p-1 font-extrabold bg-red-500 cursor-pointer" @click="clickUnfollow" tabindex="0">
                                    언팔로우 하기
                                </a>
                            </div>
                        </div>
                    </div>
                    <ul class="flex relative my-3">
                        <li class="mr-5">
                            <span class="">
                                게시물
                                <span class="font-extrabold">
                                    {{ posts.data.length }}
                                </span>
                            </span>
                        </li>
                        <li class="mr-5">
                            <span @click="showFollowers = true" class="cursor-pointer" tabindex="0">
                                팔로워
                                <span class="font-extrabold" title="92">
                                    {{ thisUser.followers.length }}
                                </span>
                            </span>
                        </li>
                        <li class="mr-5">
                            <span  @click="showFollowings = true" class="cursor-pointer" tabindex="0">
                                팔로우
                                <span class="font-extrabold">
                                    {{ thisUser.followings.length }}
                                </span>
                            </span>
                        </li>
                    </ul>
                </section>
            </div>
            <div class="grid grid-cols-3 lg:gap-7 gap-1 mt-5">
                <div v-for="post in posts.data" :key="post.id" class="relative h-0 pb-2/3 pt-1/3 bg-black cursor-pointer">
                    <post-preview :post="post" @getPosts="getPosts"></post-preview>
                </div>
            </div>
            <div v-if="gettingMorePosts" class="h-32 flex justify-center">
                <img src="/storage/loading.gif" alt="">
            </div>
        </div>
        <div v-else class="flex h-screen items-center justify-center">
            <img src="/storage/loading.gif" alt="">
        </div>
        <user-list :users="thisUser.followings" :title="'follow'" :show="showFollowings" @close="showFollowings = false"></user-list>
        <user-list :users="thisUser.followers" :title="'follower'" :show="showFollowers" @close="showFollowers = false"></user-list>
    </app-layout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import PostPreview from '@/Pages/PostPreview.vue'
import UserList from './UserList.vue'

export default {
    props: [
        'thisUser',
    ],
    components: {
        AppLayout,
        PostPreview,
        UserList
    },
    data() {
        return {
            showFollowings: false,
            showFollowers: false,
            posts: [],
            isLoading: false,
            gettingMorePosts: false,
        }
    },
    computed: {
        isMe() {
            if (this.thisUser.id == this.$page.props.user.id) {
                return true;
            }
            return false;
        },
        isFollowed() {
            for (let key in this.thisUser.followers) {
                if (this.thisUser.followers[key].id == this.$page.props.user.id) {
                    return true;
                }
            }
            return false;
        }
    },
    methods: {
        clickFollow() {
            this.$inertia.form({
                id: this.thisUser.id,
            }).post('/user/requestFollow', {
                onSuccess: () => this.isFollowed = true,
            });
        },
        clickUnfollow() {
            this.$inertia.form({
                id: this.thisUser.id,
            }).post('/user/requestUnfollow', {
                onSuccess: () => this.isFollowed = false,
            });
        },
        getPosts() {
            this.isLoading = true;
            axios.get('/user/getPosts/'+this.thisUser.id).then(response => {
                this.posts = response.data;
                console.log('userPage에서 getPosts메소드 발동');
                this.isLoading = false;
            }).catch(error=> {
                console.log(error);
            });
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
