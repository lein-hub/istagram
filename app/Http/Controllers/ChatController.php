<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Models\Channel;
use App\Models\ChannelUser;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index()
    {
        $followings = User::where('id', Auth::user()->id)->with('followings')->get()[0]->followings;
        return Inertia::render('Chat/Container', [
            'followings' => $followings,
        ]);
    }

    public function channels(Request $request)
    {
        $channels = Channel::where(function ($query) {
            // 내가 속한 채널들의 id 목록 생성
            $ChannelUsers = ChannelUser::where('user_id', Auth::user()->id)->get();
            $Channels_I_belonged = [];

            foreach ($ChannelUsers as $item) {
                array_push($Channels_I_belonged, $item->channel_id);
            }

            if (count($Channels_I_belonged)) {
                // 채널의 id가 내가 속한 채널들의 id와 일치하는가?
                for ($i = 0; $i < count($Channels_I_belonged); $i++) {
                    $query->orWhere('id', $Channels_I_belonged[$i]);
                }
            } else {
                // 내가 속한 채널이 없을 경우 빈 모델 반환
                $query->where('id', 'there is no channels you belonged');
            }
            // 반환 된 channel 모델을 가장 마지막 chat이 생성된 날짜를 기준으로 정렬 (latest_message_on)
        })->selectRaw("channels.*, (SELECT MAX(created_at) from chats WHERE chats.channel_id = channels.id) as latest_message_on")
            ->with('users')
            ->orderBy("latest_message_on", "DESC")
            ->get();

        return $channels;
    }

    public function chats(Request $request, $channelId)
    {

        $chats = Chat::where('channel_id', $channelId)->with('user')->latest()->paginate(10);
        return $chats;
    }

    public function newChat(Request $request, $channelId)
    {
        $newChat = new Chat;
        $newChat->user_id = Auth::id();
        $newChat->channel_id = $channelId;
        $newChat->content = $request->content;
        $newChat->save();
        $newChat->load('user');
        broadcast(new NewChatMessage($newChat))->toOthers();

        return $newChat;
    }

    public function newChannel(Request $request)
    {
        $channels = Channel::where(function ($query) {
            $ChannelUsers = ChannelUser::where('user_id', Auth::user()->id)->get();
            $Channels_I_belonged = [];

            foreach ($ChannelUsers as $item) {
                array_push($Channels_I_belonged, $item->channel_id);
            }

            if (count($Channels_I_belonged)) {
                for ($i = 0; $i < count($Channels_I_belonged); $i++) {
                    $query->orWhere('id', $Channels_I_belonged[$i]);
                }
            } else {
                $query->where('id', 'there is no channels you belonged');
            }
        })->with('users')->orderBy('created_at', 'desc')->get();

        $thisUser = Auth::user();

        if ($channels) {
            for ($i = 0; $i < count($channels); $i++) {
                $users_in = $channels[$i]->users;
                for ($j = 0; $j < count($users_in); $j++) {
                    if ($users_in[$j]->id == $request->userId) {
                        $followings = User::where('id', Auth::user()->id)->with('followings')->get()[0]->followings;
                        return Inertia::render('Chat/Container', [
                            'followings' => $followings,
                            'goTo' => $channels[$i]->id,
                        ]);
                    }
                }
            }
        }

        $newChannel = new Channel;
        $newChannel->save();
        ChannelUser::create([
            'channel_id' => $newChannel->id,
            'user_id' => $thisUser->id,
        ]);
        ChannelUser::create([
            'channel_id' => $newChannel->id,
            'user_id' => $request->userId,
        ]);

        return redirect()->route('chat');
    }
}
