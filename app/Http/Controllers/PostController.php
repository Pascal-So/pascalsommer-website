<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $tags = array_filter(explode(',', $request->query('tags')), function($str){return $str != '';});

        $posts = Post::latest('date')->paginate(6);

        return view('index', compact('posts'));
    }
}
