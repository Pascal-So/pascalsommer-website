<?php

namespace App\Http\Controllers;

use App\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{

    public function __construct()
    {
        // everything except viewing a photo is admin only
        //$this->middleware('auth', ['except' => 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos = Photo::staged()->ordered()->get();

        return view('photos/index', compact('photos'));
    }

    /**
     * Show the form for uploading photos.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload()
    {
        return view('photos/upload');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if($request->hasFile('photos'))
        {
            foreach($request->file('photos') as $photo)
            {
                // store the file to the public directory

                $filename = $photo->store('img/photos', 'public');

                // create the entry to the database

                $p = new Photo;
                $p->path = $filename;

                $p->save();
            }
        }

        return redirect('/');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        
        return view('photos.show');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        $photo->deleteCompletely();
    }
}
