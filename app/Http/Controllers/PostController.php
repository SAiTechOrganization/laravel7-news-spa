<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $posts = Post::orderBy('created_at', 'desc')->get();

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required|string|max:30',
            'body'  => 'required|string'
        ]);

        $post = new Post;
        $post->title = $request->title;
        $post->body  = $request->body;
        $post->save();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id) {
        $post = Post::find($id);

        $comments = $post->comments()->orderBy('created_at', 'desc')->get();

        return view('posts.show', [
            'post'     => $post,
            'comments' => $comments,
        ]);
    }
}
