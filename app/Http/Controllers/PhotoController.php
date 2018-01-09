<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo;

class PhotoController extends Controller
{
    public function view(Photo $photo){
    	dd($photo->description);
    }
}
