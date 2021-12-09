<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    public function userPage($userId)
    {
        $user = User::where('id', $userId)->with(['followers', 'followings'])->get()[0];
        $postCount = Post::where('user_id', $userId)->get()->count();

        return Inertia::render('UserPage', [
            'thisUser' => $user,
            'postCount' => $postCount,
        ]);
    }

    public function getUserPosts($userId)
    {
        $posts = Post::where('user_id', $userId)->with(['user', 'comments.user', 'images', 'votes.user'])->latest()->simplePaginate(12);

        return $posts;
    }

    public function requestFollow(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $follow = new Follow([
            'follower_id' => Auth::user()->id,
            'following_id' => $request->id,
        ]);

        $follow->save();

        return redirect()->route('user.userPage', ['userId' => $request->id]);
    }

    public function requestUnfollow(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        Follow::where('follower_id', Auth::user()->id)->where('following_id', $request->id)->delete();
        return redirect()->route('user.userPage', ['userId' => $request->id]);
    }
}
