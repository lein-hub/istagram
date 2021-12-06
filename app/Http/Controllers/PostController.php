<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Models\Hashtag;
use App\Models\HashtagPost;
use App\Models\Image;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inertia\Inertia;
use PhpParser\Node\Stmt\Foreach_;

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
        if ($request->hasFile('images')) {
            $request->validate([
                'images.*' => 'required|mimes:png,jpg,jpeg|max:10240',
            ]);
        }


        $user = Auth::user();


        $hashtags = $this->string_to_hashtag_db($request->content);

        $post = new Post([
            'content' => $request->content,
            'user_id' => $user->id,
        ]);
        $post->save();

        foreach ($hashtags as $h) {
            $hashtag = Hashtag::where('name', $h)->first();
            if (!$hashtag) {
                $hashtag = Hashtag::create([
                    'name' => $h,
                ]);
            }
            HashtagPost::create([
                'hashtag_id' => $hashtag->id,
                'post_id' => $post->id
            ]);
        }

        $images = array();
        if ($request->images) {
            foreach ($request->images as $image) {
                $imagePath = Storage::disk('uploads')->put($user->email . '/posts/' . $post->id, $image);
                array_push($images, '/uploads/' . $imagePath);
            }
            Image::create([
                'images' => json_encode($images),
                'post_id' => $post->id,
            ]);

            // foreach ($request->file('images') as $file) {
            //     $name = time() . '.' . $file->extension();
            //     $file->move(public_path() . '/images/', $name);
            //     $data[] = $name;
            // }

            // dd($request->file('images'));
            // $name = time() . '.' . $request->file('images')->getClientOriginalName();
            // $request->file('images')->storeAs('public/images', $name);
            // $data[] = $name;
        }

        // $file = new Image();
        // $file->image = json_encode($data);
        // $file->post_id = $post->id;
        // $file->save();

        return redirect()->route('dashboard');
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
        })->with(['user', 'comments.user', 'images', 'votes.user'])->orderBy('created_at', 'desc')->paginate(5);

        return $posts;
    }

    public function destroy($postId)
    {
        Post::where('id', $postId)->delete();


        // return redirect()->route('dashboard');
        return response()->json(['result' => true]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);
        if ($request->hasFile('images')) {
            $request->validate([
                'images.*' => 'required|mimes:png,jpg,jpeg|max:10240',
            ]);
        }

        $user = Auth::user();

        $post = Post::where('id', $request->postId);
        $post->update([
            'content' => $request->content,
        ]);

        if ($request->uploadedImages || $request->hasFile('images')) {
            $images = array();

            if ($request->uploadedImages) {
                foreach ($request->uploadedImages as $image) {
                    array_push($images, $image);
                }
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = Storage::disk('uploads')->put($user->email . '/posts/' . $request->postId, $image);
                    array_push($images, '/uploads/' . $imagePath);
                }
            }

            $image = Image::where('post_id', $request->postId);

            $image->update([
                'images' => json_encode($images),
            ]);
        }

        if ($request->goUser) {
            return redirect()->route('user.userPage', [
                'userId' => $user->id,
            ]);
        }
        return redirect()->route('dashboard');

        // return response()->json(['result' => true]);
    }

    function string_to_hashtag_db($string)
    {
        try {
            if ($string) {
                $result = array();
                $re_all = "/(^|\s)*#(.+?)(?=[\s,#)]|$)/";
                $re = "/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i";
                preg_match_all($re_all, $string, $matches);
                foreach ($matches[0] as $s) {
                    $str = strip_tags(trim($s));
                    $str = substr($str, 1, strlen($str) - 1);
                    if (!preg_match($re, $str)) {
                        if (strlen($str) > 1) $result[] = $str;
                    }
                }
                return array_unique($result);
            } else throw new Exception('');
        } catch (Exception $e) {
            return array();
        }
    }

    function string_to_hashtag_content($os_type, $string)
    {
        try {
            if (in_array($os_type, ['A', 'I', 'W']) && $string) {
                $result = array();
                $re_all = "/(^|\s)*#(.+?)(?=[\s,#)]|$)/";
                $re = "/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\_|\!\?\*$#<>()\[\]\{\}]/i";
                preg_match_all($re_all, $string, $matches);
                foreach ($matches[0] as $s) {
                    $str = strip_tags(trim($s));
                    $str = substr($str, 1, strlen($str) - 1);
                    //특수문자 대체
                    if (!preg_match($re, $str)) {
                        if (strlen($str) > 1) {
                            switch ($os_type) {
                                case "A":
                                    $result["#" . $str] = "<a href='javascript:alert(\"" . $str . "\")'>#" . $str . "</a>";
                                    break;
                                case "I":
                                    $result["#" . $str] = "<a href='javascript:alert(\"" . $str . "\")'>#" . $str . "</a>";
                                    break;
                                default:
                                    break;
                            }
                        }
                    }
                }
                return strtr($string, $result) . '';
            } else throw new Exception('');
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function get_operating_system()
    {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $operating_system = 'Unknown Operating System';

        //Get the operating_system name
        if (preg_match('/linux/i', $u_agent)) {
            $operating_system = 'Linux';
        } elseif (preg_match('/macintosh|mac os x|mac_powerpc/i', $u_agent)) {
            $operating_system = 'Mac';
        } elseif (preg_match('/windows|win32|win98|win95|win16/i', $u_agent)) {
            $operating_system = 'W';  // Windows
        } elseif (preg_match('/ubuntu/i', $u_agent)) {
            $operating_system = 'Ubuntu';
        } elseif (preg_match('/iphone/i', $u_agent)) {
            $operating_system = 'I';  // IPhone
        } elseif (preg_match('/ipod/i', $u_agent)) {
            $operating_system = 'I';  // IPod
        } elseif (preg_match('/ipad/i', $u_agent)) {
            $operating_system = 'I';  // IPad
        } elseif (preg_match('/android/i', $u_agent)) {
            $operating_system = 'A';  // Android
        } elseif (preg_match('/blackberry/i', $u_agent)) {
            $operating_system = 'Blackberry';
        } elseif (preg_match('/webos/i', $u_agent)) {
            $operating_system = 'Mobile';
        }

        return $operating_system;
    }
}
