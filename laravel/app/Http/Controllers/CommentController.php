<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Photo;
use App\Comment;
use App\Blacklist;
use App\Rules\NoHTML;

class CommentController extends Controller
{
    private function logBlockedComment(string $name, string $comment)
    {
        Log::info('Blocked comment: ' . json_encode(compact('author', 'comment')));
    }

    public function postComment(Photo $photo, Request $request)
    {
        // when validating incoming comments, we only validate basic stuff first,
        // and then scan the blacklist before doing further validation. This is
        // because we want the requests that are definitely spam to not get any
        // error messages, but other stuff that contains html or so can get an
        // error message back.

        $back_url = route('viewPhoto', compact('photo')) . '#comment-form';

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'comment' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect($back_url)
                        ->withErrors($validator)
                        ->withInput();
        }


        if (!Blacklist::checkComment($request->comment)) {
            $this->logBlockedComment($request->name, $request->comment);

            return redirect()->route('viewPhoto', compact('photo'));
        }

        $validator = Validator::make($request->all(), [
            'name' => [new NoHTML],
            'comment' => ['max:10000', new NoHTML],
        ]);

        if ($validator->fails()) {
            $this->logBlockedComment($request->name, $request->comment);

            return redirect($back_url)
                        ->withErrors($validator)
                        ->withInput();
        }

        if (config('constants.push_notifications')) {
            $message_title = $photo->isPublic() ? "{$request->name} in '{$photo->post->title}'" : $request->name;
            $message_content = $request->comment;

            \Simplepush::send(env('SIMPLEPUSH_KEY'), $message_title, $message_content, 'Comment');
        }

        $photo->comments()->create($request->only(['name', 'comment']));

        return redirect()->route('viewPhoto', compact('photo'));
    }

    public function delete(Comment $comment)
    {
        $comment->delete();

        return back();
    }

    public function adminIndex()
    {
        $comments = Comment::latest()->get();
        
        return view('comment.index', compact('comments'));
    }
}
