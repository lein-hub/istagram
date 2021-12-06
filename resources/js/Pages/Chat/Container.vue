<template lang="">
    <app-layout title="Direct Messages">
        <template #header>
            <h2>
                DirectMessage
                <span class="hover:bg-gray-200 p-1 rounded" @click="listShow = true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </span>
            </h2>
        </template>

        <div class="flex">
            <div class="border-r w-72 overflow-auto">
                <channel-selection :channels="channels" :currentChannel="currentChannel" @channelChanged="setChannel($event)"></channel-selection>
            </div>
            <div class="py-12 w-full">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div></div>
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <chat-container :chats="chats" @getMoreChats="getMoreChats"></chat-container>
                        <input-chat :channel="currentChannel" @messageSent="getChats()"></input-chat>
                    </div>
                </div>
            </div>
        </div>
        <user-list :show="listShow" :users="followings" @closeListModal="close" :max-width="'sm'"></user-list>
    </app-layout>
</template>
<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import ChatContainer from '@/Pages/Chat/ChatContainer.vue'
import InputChat from '@/Pages/Chat/InputChat.vue'
import ChannelSelection from './ChannelSelection.vue'
import UserList from './UserList.vue'

export default defineComponent ({
    components: {
        AppLayout,
        ChatContainer,
        InputChat,
        ChannelSelection,
        UserList,
    },
    props: [
        'followings',
        'goTo'
    ],
    data() {
        return {
            channels: [],
            currentChannel: '',
            chats: [],
            listShow: false,
        }
    },
    methods: {
        connect() {
            if (this.currentChannel) {
                let vm = this;
                this.getChats();
                console.log('connected');
                window.Echo.private('chat.'+this.currentChannel.id).listen('.message.new', (e)=>{
                    console.log('listened!!');
                    // vm.getChats();
                    vm.chats = [e.chatMessage, ...vm.chats];
                })
            }
        },
        disconnect(channel) {
            window.Echo.leave('chat.' + channel.id);
        },
        getChannels() {
            axios.get('/dm/channels')
            .then(response=>{
                console.log(response.data);
                this.channels = response.data;
                if (this.goTo) {
                    this.channels.forEach(e=>{
                        if (e.id == this.goTo) {
                            this.setChannel(e);
                        }
                    })
                } else {
                    this.setChannel(response.data[0]);
                }
            })
            .catch(error=>{
                console.log(error);
            })
        },
        setChannel(channel) {
            this.currentChannel = channel;
        },
        getChats() {
            axios.get('/dm/channel/' + this.currentChannel.id + '/chats')
            .then(response=>{
                this.chats = response.data;
            })
            .catch(error=>{
                console.log(error);
            })
        },
        getMoreChats() {
            if (this.chats.current_page == this.chats.last_page) {
                return
            }
            axios.get(this.chats.next_page_url).then(response => {
                // this.chats = response.data
                // this.chats.data = [...this.chats.data, ...response.data.data];
                this.chats = {...response.data, 'data': [...this.chats.data, ...response.data.data]};
            }).catch(error => {
                console.log(error);
            });
        },
        close() {
            this.listShow = false;
        }
    },
    watch: {
        currentChannel(val, oldVal) {
            if (oldVal.id) {
                this.disconnect(oldVal);
            }
            this.connect();
        }
    },
    created() {
        this.getChannels();
    },

})
</script>
<style lang="">

</style>
