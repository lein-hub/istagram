<template lang="">
    <app-layout>
        <div class="bg-gray-600 lg:w-9/12 lg:mx-auto mt-5 mx-3">
            <div class="grid grid-cols-3">
                <div class="col-span-1">
                    <img class="h-full rounded-full mx-auto" :src="thisUser.profile_photo_url" alt="">
                </div>

                <section class="col-span-2 bg-blue-200 pl-5">
                    <div class="flex my-3">
                        <h2 class="mr-5 text-2xl">
                            {{ thisUser.name }}
                        </h2>
                        <div v-if="isMe">
                            <div class="mr-5">
                                <a class="border rounded mr-5 p-1 font-extrabold" href="/accounts/edit/" tabindex="0">
                                    프로필 편집
                                </a>
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
                        <div class="">
                            <button class="" type="button">
                                <div class="">
                                    <svg aria-label="옵션" class="_8-yf5 " color="#262626" fill="#262626" height="24" role="img" viewBox="0 0 48 48" width="24">
                                        <path clip-rule="evenodd" d="M46.7 20.6l-2.1-1.1c-.4-.2-.7-.5-.8-1-.5-1.6-1.1-3.2-1.9-4.7-.2-.4-.3-.8-.1-1.2l.8-2.3c.2-.5 0-1.1-.4-1.5l-2.9-2.9c-.4-.4-1-.5-1.5-.4l-2.3.8c-.4.1-.8.1-1.2-.1-1.4-.8-3-1.5-4.6-1.9-.4-.1-.8-.4-1-.8l-1.1-2.2c-.3-.5-.8-.8-1.3-.8h-4.1c-.6 0-1.1.3-1.3.8l-1.1 2.2c-.2.4-.5.7-1 .8-1.6.5-3.2 1.1-4.6 1.9-.4.2-.8.3-1.2.1l-2.3-.8c-.5-.2-1.1 0-1.5.4L5.9 8.8c-.4.4-.5 1-.4 1.5l.8 2.3c.1.4.1.8-.1 1.2-.8 1.5-1.5 3-1.9 4.7-.1.4-.4.8-.8 1l-2.1 1.1c-.5.3-.8.8-.8 1.3V26c0 .6.3 1.1.8 1.3l2.1 1.1c.4.2.7.5.8 1 .5 1.6 1.1 3.2 1.9 4.7.2.4.3.8.1 1.2l-.8 2.3c-.2.5 0 1.1.4 1.5L8.8 42c.4.4 1 .5 1.5.4l2.3-.8c.4-.1.8-.1 1.2.1 1.4.8 3 1.5 4.6 1.9.4.1.8.4 1 .8l1.1 2.2c.3.5.8.8 1.3.8h4.1c.6 0 1.1-.3 1.3-.8l1.1-2.2c.2-.4.5-.7 1-.8 1.6-.5 3.2-1.1 4.6-1.9.4-.2.8-.3 1.2-.1l2.3.8c.5.2 1.1 0 1.5-.4l2.9-2.9c.4-.4.5-1 .4-1.5l-.8-2.3c-.1-.4-.1-.8.1-1.2.8-1.5 1.5-3 1.9-4.7.1-.4.4-.8.8-1l2.1-1.1c.5-.3.8-.8.8-1.3v-4.1c.4-.5.1-1.1-.4-1.3zM24 41.5c-9.7 0-17.5-7.8-17.5-17.5S14.3 6.5 24 6.5 41.5 14.3 41.5 24 33.7 41.5 24 41.5z" fill-rule="evenodd">
                                        </path>
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </div>
                    <ul class="flex relative my-3">
                        <li class="mr-5">
                            <span class="">
                                게시물
                                <span class="font-extrabold">
                                    {{ posts.length }}
                                </span>
                            </span>
                        </li>
                        <li class="mr-5">
                            <a class="" href="/cudust_v/followers/" tabindex="0">
                                팔로워
                                <span class="font-extrabold" title="92">
                                    {{ thisUser.followers.length }}
                                </span>
                            </a>
                        </li>
                        <li class="mr-5">
                            <a class="" href="/cudust_v/following/" tabindex="0">
                                팔로우
                                <span class="font-extrabold">
                                    {{ thisUser.followings.length }}
                                </span>
                            </a>
                        </li>
                    </ul>
                    <div class="my-3">
                        <h1 class="font-extrabold">
                            박동재
                        </h1><br>
                    </div>
                </section>
            </div>
            <div class="bg-green-300 mt-16 grid justify-items-center">
                <div class="bg-green-500 w-1/3 flex px-3 justify-between">
                    <button>1</button>
                    <button>2</button>
                    <button>3</button>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-3">
                <div class="bg-pink-200 cursor-pointer">
                    <img class="object-cover overflow-hidden" src="https://3.bp.blogspot.com/-Chu20FDi9Ek/WoOD-ehQ29I/AAAAAAAAK7U/mc4CAiTYOY8VzOFzBKdR52aLRiyjqu0MwCLcBGAs/s1600/DSC04596%2B%25282%2529.JPG" alt="">
                </div>
                <div class="bg-pink-200">2</div>
                <div class="bg-pink-200">3</div>
                <div class="bg-pink-200">4</div>
                <div class="bg-pink-200">5</div>
                <div class="bg-pink-200">6</div>
                <div class="bg-pink-200">7</div>
                <div class="bg-pink-200">8</div>
                <div class="bg-pink-200">9</div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import AppLayout from '@/Layouts/AppLayout.vue'

export default {
    props: [
        'thisUser',
        'posts',
    ],
    components: {
        AppLayout
    },
    data() {
        return {
            isMe: false,
            isFollowed: false,
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
        }
    },
    created() {
        for (let key in this.thisUser.followers) {
            if (this.thisUser.followers[key].id == this.$page.props.user.id) {
                this.isFollowed = true;
                break;
            }
        }
        if (this.thisUser.id == this.$page.props.user.id) {
            this.isMe = true;
        }
    },
}
</script>
<style lang="">

</style>
