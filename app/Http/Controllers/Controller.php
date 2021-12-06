<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Hashtag;
use App\Models\HashtagPost;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {

        // $posts = $this->getPosts();



        return Inertia::render('Dashboard');
    }

    public function getPosts()
    {
        $posts = Post::where(function ($query) {
            // 우선 내가 팔로잉 중인 유저들의 id와 나의 id를 원소로 가진 배열을 생성하자
            $followings = Follow::where('follower_id', Auth::user()->id)->get();
            $followings_and_me = [];
            array_push($followings_and_me, Auth::user()->id);
            foreach ($followings as $item) {
                array_push($followings_and_me, $item->following_id);
            }

            // 나와 내가 팔로잉 중인 사람들의 Post만 가져오는 쿼리 생성
            for ($i = 0; $i < count($followings_and_me); $i++) {
                $query->orWhere('user_id', $followings_and_me[$i]);
            }
        })->with(['user', 'comments.user', 'images', 'votes.user'])->orderBy('created_at', 'desc')->simplePaginate(5);

        return $posts;
    }

    public function explore($hashtagName)
    {
        $posts = Hashtag::where('name', $hashtagName)->first()->posts()->with(['user', 'comments.user', 'images'])->orderBy('created_at', 'desc')->get();

        return Inertia::render('Explore', [
            'posts' => fn () => $posts,
            'tagname' => fn () => $hashtagName,
        ]);
    }

    public function autocomplete($hashtagName)
    {
        $data = Hashtag::with('posts')->where('name', "LIKE", $hashtagName . '%')
            ->where('name', 'NOT LIKE', '% %')
            ->limit(5)
            ->distinct()
            ->orderBy('name')
            ->get();
        $data2 = Hashtag::with('posts')->where('name', "LIKE", '%' . $hashtagName . '%')
            ->where('name', 'NOT LIKE', $hashtagName . '%')
            ->limit(5)
            ->distinct()
            ->orderBy('name')
            ->get();

        $data = $data->merge($data2)->take(5);
        // $data->load('posts');

        $hashtags = array();

        foreach ($data as $d) {
            if (count($d->posts)) {
                array_push($hashtags, $d->name);
            }
        };


        // return response()->json($data);
        return $hashtags;
    }
}
