<?php

namespace App\Http\Controllers;

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
            dd($request->file('images'));
            $name = time() . '.' . $request->file('images')->getClientOriginalName();
            $request->file('images')->storeAs('public/images', $name);
            $data[] = $name;
        }

        return redirect()->route('dashboard');
    }
}
