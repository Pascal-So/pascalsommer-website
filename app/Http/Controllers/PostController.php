<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Photo;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest('date')->paginate(1);

        return view('index', compact('posts'));
    }

    public function adminIndex()
    {
        $posts = Post::latest('date');

        return view('post.adminIndex', compact($posts));
    }

    public function create()
    {
        $post = new Post;

        return view('post.edit', compact($post));
    }

    private function validatePost(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'date' => 'required|regex:/\d{4}-\d{2}-\d{2}/',
            'photos' => 'required|array',
            'photos.*' => 'integer',
        ]);
    }

    public function store(Request $request)
    {
        $this->validatePost($request);

        $this->attachPhotos($request->photos);

        return redirect()->route('posts');
    }

    public function edit(Post $post)
    {
        return view('post.edit', compact($post));
    }

    public function update(Post $post, Request $request)
    {
        $this->validatePost($request);

        $post->update($request->only('name', 'date'));

        $this->detachPhotos();

        $this->attachPhotos($request->photos);

        return redirect()->route('posts');
    }

    public function delete(Post $post)
    {
        $post->delete();

        return redirect()->route('posts');
    }
}