<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CommentController extends Controller
{
    public function getComments($postId)
    {
        $comments = Comment::where('post_id', $postId)->with('user')->get();

        return $comments;
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $comment = new Comment([
            'content' => $request->content,
            'user_id' => auth()->user()->id,
            'post_id' => $request->postId,
        ]);

        $comment->save();

        $post = Post::find($request->postId);
        $post->load(['user', 'comments.user', 'images', 'votes.user']);

        // return redirect()->route('dashboard');
        return $post;
    }

    public function destroy($postId, $commentId)
    {
        Comment::find($commentId)->delete();

        $post = Post::where('id', $postId)->first();
        $post->load(['user', 'comments.user', 'images', 'votes.user']);


        // return redirect()->route('post.show', ['postId' => $postId]);
        // return response()->json(['result' => true]);
        return $post;
    }

    public function update(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $comment = Comment::where('id', $request->id);
        $postId = $request->post_id;
        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->route('post.show', ['postId' => $postId]);
    }

    public function editForm($commentId)
    {
        $comment = Comment::where('id', $commentId)->get()[0];

        return Inertia::render('Post/CommentEditForm', [
            'comment' => $comment
        ]);
    }
}
