<template lang="">
    <div class="block w-full overflow-x-auto">
        <table class="items-center bg-transparent w-full border-collapse ">
            <tbody v-if="channels.length">
                <tr class="hover:bg-gray-200" @click="clickChannelBtn(channel)" v-for="channel in channels" :key="channel.id">
                    <td class="border-t-0 px-6 py-3 align-middle border-l-0 border-r-0 text-md align-center flex whitespace-nowrap">
                        <!-- <button class="block h-8 w-8 rounded-full overflow-hidden border-2 border-gray-600 focus:outline-none focus:border-white">
                            <img @click="showUserPage(vote.user_id)" class="h-full w-full object-cover" :src="vote.user.profile_photo_url" alt="">
                        </button> -->
                        <span class="px-6">
                            {{ getChannelName(channel) }}
                        </span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    props: [
        'channels',
        'currentChannel'
    ],
    data() {
        return {
            selected: '',
        }
    },
    methods: {
        clickChannelBtn(channel) {
            this.selected = channel;
            this.$emit('channelChanged', this.selected);
        },
        getChannelName(channel) {
            let name = '';
            for (let i=0; i<channel.users.length; i++) {
                if (channel.users[i].name != this.$page.props.user.name) {
                    if (name) {
                        name = name + `, ${channel.users[i].name}`;
                    } else {
                        name = name + channel.users[i].name;
                    }
                }
            }
            return name;
            return 'temp'
        }
    },
    created() {
        this.selected = this.currentChannel;
    }
}
</script>
<style lang="">

</style>
