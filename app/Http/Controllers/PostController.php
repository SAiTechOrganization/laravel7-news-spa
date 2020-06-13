<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function index() {
        $posts = Post::all();

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required|max:30',
            'body'  => 'required'
        ]);

        $post = new Post;
        $post->title = $request->title;
        $post->body  = $request->body;
        $post->save();

        return redirect()->back();
    }
}
