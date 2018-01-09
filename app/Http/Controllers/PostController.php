<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function index(){
    	$posts = Post::latest('date')->paginate(1);

    	return view('index', compact('posts'));
    }
}
