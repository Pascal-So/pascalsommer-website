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
    private function logBlockedComment(string $name, string $comment, int $photo_id)
    {
        $json = json_encode(compact('name', 'comment', 'photo_id'),
                            JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        Log::info('Blocked comment: ' . $json);
    }

    public function postComment(Photo $photo, Request $request)
    {
        // when validating incoming comments, we only validate basic stuff first,
        // and then scan the blacklist before doing further validation. This is
        // because we want the requests that are definitely spam to not get any
        // error messages, but other stuff that contains html or so can get an
        // error message back.

        $back_url = $photo->url() . '#comment-form';

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
            $this->logBlockedComment($request->name, $request->comment, $photo->id);

            return redirect($photo->url());
        }

        $validator = Validator::make($request->all(), [
            'name' => [new NoHTML],
            'comment' => ['max:10000', new NoHTML],
        ]);

        if ($validator->fails()) {
            $this->logBlockedComment($request->name, $request->comment, $photo->id);

            return redirect($back_url)
                        ->withErrors($validator)
                        ->withInput();
        }

        $photo->comments()->create($request->only(['name', 'comment']));

        if (config('constants.push_notifications')) {
            $message_title = $photo->isPublic() ? "{$request->name} in '{$photo->post->title}'" : $request->name;
            $message_content = $request->comment;

            \Simplepush::send(env('SIMPLEPUSH_KEY'), $message_title, $message_content, 'Comment');
        }

        return redirect($photo->url());
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
