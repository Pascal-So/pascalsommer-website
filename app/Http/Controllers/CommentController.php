<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo;
use App\Comment;

class CommentController extends Controller
{
    public function postComment(Photo $photo, Request $request){
    	$this->validate($request, [
    		'name' => 'required|max:255',
    		'comment' => 'required|max:5000',
    	]);

    	$photo->comments()->create($request->only(['name', 'comment']));

    	return redirect()->route('viewPhoto', compact('photo'));
    }

    public function delete(Comment $comment){
    	$comment->delete();

    	return back();
    }

    public function adminIndex(){
    	$comments = Comment::latest()->get();
    	
    	return view('comment.index', compact('comments'));
    }
}
