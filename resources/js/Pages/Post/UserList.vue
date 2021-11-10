<template lang="">

    <jet-dialog-modal :show="createFormShow" @close="close">
        <template #content>
            <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded ">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center">
                        <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                            <h3 class="font-semibold text-base text-blueGray-700">이 게시글에 좋아요 누른 사람</h3>
                        </div>
                    </div>
                </div>
                <div class="block w-full overflow-x-auto">
                    <table class="items-center bg-transparent w-full border-collapse ">
                        <thead>
                            <tr>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    사진
                                </th>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    이름
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="user in users" :key="user.id">
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 ">
                                    <img :src="user.profile_photo_url" alt="">
                                </td>
                                <td class="border-t-0 px-6 align-center border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    {{ user.name }}
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
    props: [
        'users', 'show'
    ],
    methods: {
        close() {
            this.$emit('closeModal');
        },
    },
})
</script>
<style lang="">

</style>
