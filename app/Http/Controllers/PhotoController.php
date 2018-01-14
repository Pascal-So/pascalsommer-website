<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo;
use App\Post;

class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::latest()->get();

        return view('photo.index', compact('photos'));
    }

    public function view(Photo $photo)
    {
        return view('photo.view', compact('photo'));
    }

    public function filtered(string $tags)
    {
        $tags_arr = array_filter(explode(',', $tags), function($str){return $str != '';});

        // The has('tags') call is redundant, it's just here to get a query builder object we can work with
        $query = Photo::has('tags');

        // This might get inefficient as the amount of tags filtered for grows, but that's ok,
        // because usually count($tags_arr) is just 1.
        foreach($tags_arr as $tag){
            $query->whereHas('tags', function($q) use ($tag){
                $q->where('name', $tag);
            });
        }


        // todo: this overrides the photo id with the post id. FIX THIS
        $query->join('posts', 'photos.post_id', '=', 'posts.id')
              ->orderBy('date', 'desc')
              ->orderBy('weight');

        $photos = $query->paginate(10);

        return view('photo.filtered', compact('tags_arr', 'photos'));
    }
}
