<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index() {
        return Post::orderBy('created_at', 'desc')->paginate(10);
    }

    public function store(Request $request) {
        $this->validate(
            $request,
            [
                'title'     => 'required|string|max:30',
                'body'      => 'required|string',
                'thumbnail' => 'nullable|max:2894070|regex:/^data:image\/\w+;base64,[a-zA-Z0-9\/\r\n+]*={0,2}$/'
            ],
            [
                'title.required'  => 'タイトルは必須です。',
                'title.string'    => 'タイトルには文字列を入力してください。',
                'title.max'       => 'タイトルは30文字以下です。',
                'body.required'   => '記事は必須です。',
                'body.string'     => '記事には文字列を入力してください。',
                'thumbnail.max'   => 'サムネイルのファイルサイズは2.0MBまでです。',
                'thumbnail.regex' => 'サムネイルには画像ファイルを選択してください。',
            ]
        );

        $post = new Post;

        $post->title     = $request->title;
        $post->body      = $request->body;
        $post->thumbnail = $request->thumbnail;

        $post->save();

        return $post;
    }

    public function show(int $id) {
        $post = Post::find($id);

        $comments = $post->comments()->orderBy('created_at', 'desc')->get();

        return [
            'post'     => $post,
            'comments' => $comments,
        ];
    }

}
