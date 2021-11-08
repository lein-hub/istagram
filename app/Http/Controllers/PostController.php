<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostController extends Controller
{
    public function form()
    {
        return Inertia::render('Post/CreateForm');
    }

    public function create(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $post = new Post([
            'content' => $request->content,
            'user_id' => Auth::user()->id,
        ]);
        $post->save();

        $data[] = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $name = time() . '.' . $file->extension();
                $file->move(public_path() . '/images/', $name);
                $data[] = $name;
            }
            // dd($request->file('images'));
            // $name = time() . '.' . $request->file('images')->getClientOriginalName();
            // $request->file('images')->storeAs('public/images', $name);
            // $data[] = $name;
        }

        $file = new Image();
        $file->image = json_encode($data);
        $file->post_id = $post->id;
        $file->save();

        return redirect()->route('dashboard');
    }

    public function destroy($postId)
    {
        Post::where('id', $postId)->delete();


        return redirect()->route('dashboard');
    }

    public function update(Request $request)
    {
        $post = Post::where('id', $request->postId);
        $post->update([
            'content' => $request->content,
        ]);

        return redirect()->route('dashboard');
    }
}
