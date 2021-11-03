<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $posts = Post::with(['user', 'comments.user'])->latest()->get();

        return Inertia::render('Dashboard', [
            'posts' => $posts
        ]);
    }

    public function userPage($userId)
    {
        $user = User::find($userId);
        $posts = Post::where('user_id', $userId)->with(['user', 'comments.user'])->latest()->get();
        return Inertia::render('UserPage', [
            'user' => $user,
            'posts' => $posts
        ]);
    }
}
