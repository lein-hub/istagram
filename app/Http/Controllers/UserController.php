<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
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
