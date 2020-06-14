<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

        $comment = new Comment;
        $comment->post_id = $request->post_id;
        $comment->body    = $request->body;
        $comment->save();
        
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return redirect()->back();
    }
}
