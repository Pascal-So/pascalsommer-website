<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo;
use App\Post;
use App\Tag;
use App\Rules\NoHTML;
use Illuminate\Support\Str;


class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::latest()->get();

        return view('photo.index', compact('photos'));
    }

    public function view(Photo $photo)
    {
        // not logged in users aren't allowed to see unpublished photos
        if( ! $photo->isPublic() && ! \Auth::check()){
            abort(404);
        }

        return view('photo.view', compact('photo'));

    }

    public function filtered(string $tags = '')
    {
        $tags_arr = collect(explode(',', $tags))->filter(function($str){return $str != '';});

        $unused_tags_arr = Tag::has('photos')->get()->pluck('name')->diff($tags_arr)->sort();

        // The has('tags') call is redundant, it's just here to get a query builder object we can work with
        $query = Photo::has('tags');

        // This might get inefficient as the amount of tags filtered for grows, but that's ok,
        // because usually count($tags_arr) is just 1.
        foreach($tags_arr as $tag){
            $query->whereHas('tags', function($q) use ($tag){
                $q->where('name', $tag);
            });
        }

        $query->join('posts as p', 'photos.post_id', '=', 'p.id')
              ->orderBy('p.date', 'desc')
              ->orderBy('weight', 'asc');
        
        // the explicit select statement is necessary, because otherwise, the photo id
        // gets overwritten by the post id.
        $query->select('photos.id', 'photos.path', 'photos.description');

        $photos = $query->paginate(10);

        return view('photo.filtered', compact('tags_arr', 'photos', 'unused_tags_arr'));
    }

    public function adminIndex()
    {
        $photos = Photo::get();

        return view('photo.adminIndex', compact('photos'));
    }

    public function edit(Photo $photo)
    {
        $other_tags = Tag::whereNotIn('id', $photo->tags->pluck('id'))->get();

        return view('photo.edit', compact('photo', 'other_tags'));
    }

    public function update(Photo $photo, Request $request)
    {
        $request->validate([
            'description' => ['max:10000', new NoHTML],
        ]);

        $photo->update($request->only('description', 'path'));

        return redirect()->route('photos');
    }

    public function delete(Photo $photo)
    {
        $photo->delete();

        return redirect()->back();
    }

    public function staging()
    {
        $photos = Photo::where('post_id', null)->get();

        return view('photo.staging', compact('photos'));
    }

    public function showUploadForm()
    {
        return view('photo.uploadForm');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'photos' => 'required|array',
            'photos.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        foreach($request->photos as $photo){
            $generated_name = Str::random(10) . '-' . $photo->getClientOriginalName();

            $filename = $photo->storeAs(config('constants.photos_path'), $generated_name);

            Photo::create([
                'path' => $filename,
                'description' => '',
            ]);
        }

        return redirect()->route('photos');
    }

    public function addTag(Photo $photo, Tag $tag)
    {
        $photo->tags()->attach($tag);

        return redirect()->route('editPhoto', compact('photo'));
    }

    public function removeTag(Photo $photo, Tag $tag)
    {
        $photo->tags()->detach($tag);

        return redirect()->route('editPhoto', compact('photo'));
    }
}