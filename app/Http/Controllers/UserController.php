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
        $posts = Post::where('user_id', $userId)->with(['user', 'comments.user', 'images'])->latest()->get();
        return Inertia::render('UserPage', [
            'thisUser' => $user,
            'posts' => $posts,
        ]);
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

        return redirect()->route('userPage', ['user_id' => $request->id]);
    }

    public function requestUnfollow(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        Follow::where('follower_id', Auth::user()->id)->where('following_id', $request->id)->delete();
        return redirect()->route('userPage', ['user_id' => $request->id]);
    }
}
