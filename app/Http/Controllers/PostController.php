<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function getDashboard()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(4);
        //$posts = Post::orderBy('created_at', 'desc')->get(); //it's without pagination.
        return view('dashboard', ['posts' => $posts]);
    }

    public function postCreatePost(Request $request)
    {
        $this->validate($request, [
            'body' => 'required|max:1000'
        ]);

        $post       = new Post();
        $post->body = $request['body'];
        $message    = 'This was an error!';
        if ($request->user()->posts()->save($post)) {
            $message = 'Post successfully created!';
        }
        return redirect()->back()->with(['message' => $message]);
    }

    public function getSinglePost($post_id)
    {
        $posts = DB::table('posts')->where('id', $post_id)->get();
        return view('single', ['posts' => $posts]);
    }

    public function getDeletePost($post_id)
    {
        $post = Post::where('id', $post_id)->first();
        if (Auth::user() != $post->user) {
            return redirect()->back();
        }
        $post->delete();
        return redirect()->back()->with(['message' => 'Post has deleted successfully!']);
    }

    public function postEditPost(Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);
        $post = Post::find($request['postId']);
        if (Auth::user() != $post->user) {
            return redirect()->back();
        }
        $post->body = $request['body'];
        $post->update();
        return response()->json(['new_body' => $post->body], 200);
    }

    public function getLogout()
    {
        Auth::Logout();
        return redirect()->route('home');
    }
} 