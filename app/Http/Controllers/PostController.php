<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Photo;

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
            'photo_ids' => 'required',
        ]);


        $photo_ids = $request->input('photo_ids');
        $post_title = $request->input('title');
        $publish_date = $request->input('publish_date', Carbon::now('UTC'));


        // create the model for the posts table

        $post = new Post;

        $post->title = $post_title;
        $post->publish_date = $publish_date;

        $post->save();

        // get the id of the post we just created

        $post_id = $post->id;


        // Associate the photos with the post and set the order within the post

        $current_index_in_post = 1;

        foreach ($photo_ids as $photo_id) {


            $photo = Photo::find($photo_id);

            $photo->index_in_post = $current_index_in_post;
            $photo->post_id = $post_id;

            $photo->save();

            $current_index_in_post++;
        }


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
        $this->deleteCompletely();
        Log::info("Deleted post with title \"{$post->title}\" and id {$post->id}.");
        return redirect('/');
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
