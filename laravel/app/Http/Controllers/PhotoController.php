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
        $query = Photo::published();

        // This might get inefficient as the amount of tags filtered for grows, but that's ok,
        // because usually count($tags_arr) is just 1.
        foreach($tags_arr as $tag){
            $query->whereHas('tags', function($q) use ($tag){
                $q->where('name', $tag);
            });
        }

        $photos = $query->blogOrdered()->paginate(10);

        return view('photo.filtered', compact('tags_arr', 'photos', 'unused_tags_arr'));
    }

    public function adminIndex(bool $only_staging = false)
    {
        $photos_query = $only_staging ? Photo::staged() : Photo::query();

        $photos = $photos_query->blogOrdered()->get();

        return view('photo.adminIndex', compact('photos', 'only_staging'));
    }

    public function staging()
    {
        return $this->adminIndex(true);
    }

    public function edit(Photo $photo)
    {
        $other_tags = Tag::whereNotIn('id', $photo->tags->pluck('id'))->get();

        $tags = Tag::get();

        return view('photo.edit', compact('photo', 'other_tags', 'tags'));
    }

    public function update(Photo $photo, Request $request)
    {
        $request->validate([
            'description' => ['max:10000', new NoHTML],
        ]);

        $photo->description = $request->description ?: '';

        $photo->save();

        return redirect()->route('photos');
    }

    public function delete(Photo $photo)
    {
        $public = $photo->isPublic();

        $post = $photo->post;

        $photo->delete();

        if($public && $post->photos->isEmpty()){
            $post->delete();
        }

        return redirect()->back();
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

        return redirect(route('editPhoto', compact('photo')) . '#photo');
    }

    public function removeTag(Photo $photo, Tag $tag)
    {
        $photo->tags()->detach($tag);

        return redirect(route('editPhoto', compact('photo')) . '#photo');
    }

    public function gallery()
    {
        $photos = Photo::published()->blogOrdered()->paginate(2*3*4*5);

        return view('photo.gallery', compact('photos'));
    }
}