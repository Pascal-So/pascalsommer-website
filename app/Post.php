<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Photo;

class Post extends Model
{
    public static $posts_per_page = 6;

    protected $guarded = ['id'];

    public function photos()
    {
        return $this->hasMany(Photo::class)->orderBy('weight', 'asc');
    }

    public function scopeBefore($query)
    {
        return $query->where('date', '<', $this->date)
                     ->orWhere(function($query){
                        $query->where('date', $this->date)
                              ->where('id', '<', $this->id);
                     });
    }

    public function scopeAfter($query)
    {
        return $query->where('date', '>', $this->date)
                     ->orWhere(function($query){
                        $query->where('date', $this->date)
                              ->where('id', '>', $this->id);
                     });
    }

    public function prevPost()
    {
        return Post::before($this)->blogOrdered()->first();
    }

    public function nextPost()
    {
        return Post::after($this)->blogOrdered(true)->first();
    }

    public function formatTitle()
    {
        return $this->title . " - " . $this->date;
    }

    public function scopeBlogOrdered($query, bool $reverse = false)
    {
        $dir = $reverse ? 'asc' : 'desc';

        return $query->orderBy('date', $dir)->orderBy('id', $dir);
    }

    /**
     * Move all the photos from this post back to staging.
     *
     **/
    public function detachPhotos()
    {
        $photo_ids = $this->photos->pluck('id');

        $this->photos()->update([
            'post_id' => null,
            'weight' => 0,
        ]);

        foreach($photo_ids as $photo_id){
            $photo = Photo::find($photo_id);
            $photo->setHighestOrderNumber();
            $photo->save();
        }
    }

    /**
     * Attach these photos to this post, in the order they are
     * given in the array.
     *
     **/
    public function attachPhotos(array $photo_ids)
    {
        Photo::whereIn('id', $photo_ids)
            -> update([
                'post_id' => $this->id,
                'weight' => 0,
            ]);

        foreach($photo_ids as $photo_id){
            $photo = Photo::find($photo_id);

            if($photo != null){
                $photo->setHighestOrderNumber();
                $photo->save();
            }
        }
    }

    /**
     * The page number on which the post will show up in the pagination.
     *
     **/
    public function getPaginationPage():int
    {
        $position = Post::after()->count();
        return $position / Post::$posts_per_page + 1;
    }

    public function delete()
    {
        $this->photos->each(function($photo){
            $photo->delete();
        });

        return parent::delete();
    }
}
