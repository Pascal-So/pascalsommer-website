<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Photo;

class Post extends Model
{
    public static $posts_per_page = 2;

    public function photos(){
        return $this->hasMany(Photo::class)->orderBy('weight', 'asc');
    }

    public function prevPost(){
        return Post::where('date', '<', $this->date)->orderBy('date')->get()->last();
    }

    public function nextPost(){
        return Post::where('date', '>', $this->date)->orderBy('date')->get()->first();
    }

    public function formatTitle(){
        return $this->title . " - " . $this->date;
    }


    /**
     * Move all the photos from this post back to staging.
     *
     **/
    private function detachPhotos()
    {
        $photo_ids = $this->photos->pluck('id');

        $this->photos->update([
            'photo_id' => null,
            'weight' => 0,
        ]);

        foreach($photo_ids as $photo_id){
            Photo::find($photo_id)->setHighestOrderNumber()->save();
        }
    }

    /**
     * Attach these photos to this post, in the order they are
     * given in the array.
     *
     **/
    private function attachPhotos(array $photo_ids)
    {
        Photo::whereIn('id', $photo_ids)
            -> update([
                'photo_id' => $this->id,
                'weight' => 0,
            ]);

        foreach($photo_ids as $photo_id){
            Photo::find($photo_id)->setHighestOrderNumber()->save();
        }
    }

    /**
     * The page number on which the post will show up in the pagination.
     *
     **/
    public function getPaginationPage():int
    {
        $position = Post::where('date', '>', $this->date)->count();
        return $position / Post::$posts_per_page + 1;
    }
}
