<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function vote(Request $request)
    {
        $request->validate([
            'postId' => 'required',
        ]);

        Vote::create([
            'user_id' => Auth::user()->id,
            'post_id' => $request->postId,
        ]);

        $post = Post::find($request->postId);
        $post->load(['user', 'comments.user', 'images', 'votes.user']);
        // return redirect()->route('dashboard');
        return $post;
    }

    public function devote(Request $request)
    {
        $request->validate([
            'postId' => 'required'
        ]);

        Vote::where('post_id', $request->postId)->where('user_id', Auth::user()->id)->delete();


        $post = Post::find($request->postId);
        $post->load(['user', 'comments.user', 'images', 'votes.user']);
        // return redirect()->route('dashboard');
        return $post;
    }
}
