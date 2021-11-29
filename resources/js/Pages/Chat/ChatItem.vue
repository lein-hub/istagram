<template lang="">
    <div>
        <div v-if="!isMe(chat)" class="flex items-end">
            <span class="p-3 bg-white rounded-3xl border border-gray-200 inline-block">
                {{ chat.user.name }} : {{ chat.content }}
            </span>
        </div>
        <div v-else class="flex items-end justify-end">
            <span class="p-3 bg-gray-200 rounded-3xl inline-block">
                {{ chat.user.name }} : {{ chat.content }}
            </span>
        </div>
    </div>
</template>
<script>
export default {
    props: [
        'chat'
    ],
    methods: {
        isMe(chat) {
            if (chat.user.id == this.$page.props.user.id) {
                return true;
            }
            return false;
        }
    },
}
</script>
<style lang="">

</style>
