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
            // 우선 내가 팔로잉 중인 유저들의 id와 나의 id를 원소로 가진 배열을 생성하자
            $ChannelUsers = ChannelUser::where('user_id', Auth::user()->id)->get();
            // array_push($Channels_I_belonged, Auth::user()->id);
            $Channels_I_belonged = [];

            foreach ($ChannelUsers as $item) {
                array_push($Channels_I_belonged, $item->channel_id);
            }

            if (count($Channels_I_belonged)) {
                // 나와 내가 팔로잉 중인 사람들의 Post만 가져오는 쿼리 생성
                for ($i = 0; $i < count($Channels_I_belonged); $i++) {
                    $query->orWhere('id', $Channels_I_belonged[$i]);
                }
            } else {
                $query->where('id', 'there is no channels you belonged');
            }
        })->with('users')->orderBy('created_at', 'desc')->get();

        return $channels;
    }

    public function chats(Request $request, $channelId)
    {

        $chats = Chat::where('channel_id', $channelId)->with('user')->latest()->get();
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
    }
}
