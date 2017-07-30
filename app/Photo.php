<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{

    // make all properties mass assignable

    protected $guarded = [];


    public function comments()
    {
    	return $this->hasMany(App\Comment::class);
    }

    public function post()
    {
    	return $this->belongsTo(Post::class);
    }


    /**
     * Is this photo live, as in visible to the public?
     *
     */
    public function isPublished()
    {
        if($this->isStaged())
        {
            return false;
        }

        return $this->post->isPublished();
    }


    /**
     * Is this photo gonna be published shortly?
     *
     */
    public function isQueued()
    {
        if($this->isStaged())
        {
            return false;
        }

        return !$this->post->isPublished();
    }


    /**
     * Is this photo not associated with a post at all?
     *
     */
    public function isStaged()
    {
        return is_null($this->post);
    }




    /**
     * return all photos that are not yet part of a post, published or not
     *
     */
    public function scopeStaged($query)
    {
        return $query->where('post_id', null);
    }


}
