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
        // validate request

        $this->validate($request, [
            'title' => 'required|unique:posts|max:255',
            'staged_photo_ids' => 'required',
            'date' => 'required' // or maybe not
        ]);


        // need to get the information from the request somehow, worry about that later..

        $staged_photo_ids = [];
        $post_title = '';
        $post_date = '';


        // get photo paths from config

        $photos_path = Config::get('constants.paths.photos');
        $staged_path = Config::get('constants.paths.staged');



        // Load StagedPhotos from database..

        $staged_photos = StagedPhoto::find($staged_photo_ids);

        // .. and order them properly

        $staged_photos = reorder_photos_by_index_array($staged_photos, $staged_photo_ids);


        // Check if all the files exist before we move anything, because that's easier than
        // setting up some kid of rollback

        foreach ($staged_photos as $staged_photo) {
            $staged_photo_path = $staged_path . $staged_photo->path;

            if(!file_exists($staged_photo_path)){
                // ERROR, file missing
                $error_message = "\"{$staged_photo_path}\" is mising while trying to create the post \"{$post_title}\". Aborting.";
                Log::error($error_message);
                $all_files_exist = false;
                

                // Abort
                

            }
        }


        // create the model for the posts table

        $post = new Post;

        $post->title = $post_title;
        $post->date = $post_date;

        $post->save();

        // get the id of the post we just created

        $post_id = $post->id;


        // All files are where they are supposed to be, we can safely start moving them and
        // creating the entries in the Photos table

        $current_index_in_post = 1;

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
            $photo->index_in_post = $current_index_in_post;

            $photo->save();

            $current_index_in_post++;
        }


        // delete the entries from the StagedPhotos table

        StagedPhoto::destroy($staged_photo_ids);

        Log::info("Successfully created posts with title \"{$post_title}\" and id {$post_id}.");

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


    /**
     * Brings an array of photos to the order that is indicated by an index array.
     *
     * @param array $photos
     *   The photos to be rearranged
     * @param array $index_array
     *   The indexes of the photos in the desired order
     * @return array $photos
     */
    private function reorder_photos_by_index_array(array $photos, array $index_array)
    {
        $output_array = [];


        // making sure the index array is indexed properly, sicne every array
        // in php is essentially a hash table

        $index_array = array_values($index_array);


        // flip the index array, to get the mapping from id to position
        // in the final array

        $index_mapping = array_flip($index_array);


        // put the photos in to the final array, dropping ones that don't
        // appear in the index array

        foreach($photos as $photo){
            $id = $photos->id;

            if(array_key_exists($id, $index_mapping)){
                $output_array[$index_mapping[$id]] = $photo;
            }
        }


        // sort the output array by keys

        ksort($output_array);

        return array_values($output_array);
    }
}
