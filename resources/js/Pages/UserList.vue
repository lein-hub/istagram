<template lang="">
    <jet-dialog-modal :show="show" @close="close">
        <template #content>
            <div class="relative flex flex-col min-w-0 break-words bg-white w-full shadow-lg rounded ">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center">
                        <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                            <h3 class="font-semibold text-base text-blueGray-700">{{getTitle}}</h3>
                        </div>
                    </div>
                </div>
                <div class="block w-full overflow-x-auto">
                    <table class="items-center bg-transparent w-full border-collapse ">

                        <tbody>
                            <tr v-for="user in users" :key="user.id">
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-md align-center flex whitespace-nowrap p-4">
                                    <button class="block h-8 w-8 rounded-full overflow-hidden border-2 border-gray-600 focus:outline-none focus:border-white">
                                        <img @click="showUserPage(user.id)" class="h-full w-full object-cover" :src="user.profile_photo_url" alt="">
                                    </button>
                                    <span class="px-6">
                                        {{ user.name }}
                                    </span>
                                </td>
                                <td class="border-t-0 px-6 align-center border-l-0 border-r-0 text-xs whitespace-nowrap p-4">

                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </template>
    </jet-dialog-modal>
</template>
<script>
import { defineComponent } from 'vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
export default defineComponent ({
    components: {
        JetDialogModal,
    },
    emits: [
        'closeListModal'
    ],
    props: [
        'users', 'show', 'title'
    ],
    computed: {
        getTitle() {
            if (this.title == 'follow') return '이 사용자가 팔로우 하는 사람';
            if (this.title == 'follower') return '이 사용자를 팔로우 하는 사람';
            return '';
        }
    },
    methods: {
        close() {
            if (this.title == 'follow') return this.$parent.showFollowings = false;
            if (this.title == 'follower') return this.$parent.showFollowers = false;
            return ;
        },
        showUserPage(userId) {
            this.$inertia.get('/user/'+ userId);
        },
    },
})
</script>
<style lang="">

</style>
