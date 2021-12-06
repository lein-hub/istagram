<template lang="">
    <div class="block w-full overflow-x-auto">
        <table class="items-center bg-transparent w-full border-collapse ">
            <tbody v-if="channels.length">
                <template  v-for="channel in channels" :key="channel.id">
                    <tr v-if="currentChannel.id == channel.id" class="hover:bg-blue-200 bg-blue-100" @click="clickChannelBtn(channel)">
                        <td class="border-t-0 px-6 py-3 align-middle border-l-0 border-r-0 text-md align-center flex whitespace-nowrap">
                            <span class="px-6">
                                {{ getChannelName(channel) }}
                            </span>
                        </td>
                    </tr>
                    <tr v-else class="hover:bg-gray-200" @click="clickChannelBtn(channel)">
                        <td class="border-t-0 px-6 py-3 align-middle border-l-0 border-r-0 text-md align-center flex whitespace-nowrap">
                            <span class="px-6">
                                {{ getChannelName(channel) }}
                            </span>
                        </td>
                    </tr>
                </template>
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
        }
    },
    created() {
        this.selected = this.currentChannel;
    }
}
</script>
<style lang="">

</style>
