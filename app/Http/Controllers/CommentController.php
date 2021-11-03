<?php

namespace App\Http\Controllers;

use App\Models\Comment;
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

        return redirect()->route('dashboard');
    }

    public function destroy(Request $request)
    {
        $comment = Comment::where('id', $request->id);
        $postId = $request->post_id;
        $comment->delete();


        return redirect()->route('post.show', ['postId' => $postId]);
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
