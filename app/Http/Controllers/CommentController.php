<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Photo;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __constructor()
    {
        //$this->middleware('auth', ['except' => 'add']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::get();

        return view('comments.index', compact('comments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Photo $photo The photo on which to add the comment.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Photo $photo, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'content' => 'required',
        ]);
        
        $photo->addComment(new Comment($request(['name', 'content'])));

        return back();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back();
    }
}
