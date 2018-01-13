<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo;
use App\Post;

class PhotoController extends Controller
{
    public function index(){
        $photos = Photo::latest()->get();

        return view('photo.index', compact('photos'));
    }

    public function view(Photo $photo){
        return view('photo.view', compact('photo'));
    }


}
