<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Photo;
use App\StagedPhoto;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // need to get the information from the request somehow, worry about that later..

        $staged_photo_ids = [];
        $post_title = '';
        $post_date = '';


        // get photo paths from config

        $photos_path = Config::get('constants.paths.photos');
        $staged_path = Config::get('constants.paths.staged');


        // create the model for the posts table

        $post = new Post;

        $post->title = $post_title;
        $post->date = $post_date;

        $post->save();

        // get the id of the post we just created

        $post_id = $post->id;



        // Load StagedPhotos from database

        $staged_photos = StagedPhoto::find($staged_photo_ids);


        // Check if all the files exist before we move anything, because that's easier than
        // setting up some kid of rollback

        $all_files_exist = true;

        foreach ($staged_photos as $staged_photo) {
            $staged_photo_path = $staged_path . $staged_photo->path;
            $all_files_exist &= file_exists($staged_photo_path);
        }

        if (!$all_files_exist){
            // TODO: ERROR in here
        }


        // All files are where they are supposed to be, we can safely start moving them and
        // creating the entries in the Photos table

        foreach ($staged_photos as $staged_photo) {

            // move the photo to the photos folder

            $old_path = $staged_path . $staged_photo->path;
            $new_path = $photos_path . $staged_photo->path;

            rename($old_path, $new_path);


            // create the entry to the Photos table

            $photo = new Photo;

            $photo->path = $staged_photo->path;
            $photo->description = $staged_photo->description;
            $photo->post_id = $post_id;

            $photo->save();
            
        }


        // delete the entries from the StagedPhotos table

        StagedPhoto::destroy($staged_photo_ids);

    }

    /**
     * Display the specified resource.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
