<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'post_id' => 'required|numeric|exists:posts,id',
                'body'    => 'required|string|max:50',
            ],
            [
                'post_id.required' => '入力値が不正です',
                'post_id.numeric'  => '入力値が不正です',
                'post_id.exists'   => '入力値が不正です',
                'body.required'    => 'コメントは必須です。',
                'body.string'      => 'コメントには文字列を入力してください。',
                'body.max'         => 'コメントは50文字以下です。',
            ]
        );

        return Comment::create([
            'post_id' => $request->post_id,
            'body'    => $request->body,
        ]);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response(null, 204);
    }

}
