<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{

    // make all properties mass assignable

    protected $guarded = [];


    public function comments()
    {
    	return $this->hasMany(Comment::class);
    }

    public function post()
    {
    	return $this->belongsTo(Post::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


    /**
     * Return the largest index in post that is currently used by a staged photo
     * 
     * @return int largest index
     */
    public function largestIndexInPost()
    {
        Photo::staged()->max('index_in_post');
    }


    /**
     * Filter for photos in the same context as the given one, e.g. staged
     * or the same post.
     *
     * @param Photo $photo Use the context of this photo
     */
    public function scopeContextOf($query, Photo $photo)
    {
        if(is_null($photo) || $photo->isStaged())
        {
            return $this->staged();
        }
        else
        {
            return $this->where('post_id', $photo->post_id);
        }
    }


    /**
     * Get the photos adjacent to the current one in the current context.
     *
     * @return array Adjacent photos as ["previous" => $previous, "next" => $next].
     */
    public function adjacentPhotos()
    {
        $current_index = $this->index_in_post;

        $previous = Photo::contextOf($this)->where('index_in_post', '<', $current_index)->ordered('desc')->first();
        $next = Photo::contextOf($this)->where('index_in_post', '>', $current_index)->ordered('asc')->first();

        return compact(['previous', 'next']);
    }


    /**
     * Move the photo by one in its context, eg within the staged
     * photos or in its current post.
     *
     * @param bool $up Move the photo up, i.e. earlier in the collection.
     */
    public function move(bool $up = true)
    {
        // the index of the current photo will be swapped with this one.
        $swap_photo = $this;

        $adjacent_photos = $this->adjacentPhotos();

        if($up)
        {
            $swap_photo = $adjacent_photos['previous'];
        }
        else
        {
            $swap_photo = $adjacent_photos['next'];
        }

        if(is_null($swap_photo))
        {
            // no adjacent photo in this direction
            return;
        }

        $swap_index = $swap_photo->index_in_post;
        $swap_photo->index_in_post = $this->index_in_post;
        $this->index_in_post = $swap_index;

        $this->save();
        $swap_photo->save();
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

        // photo isn't staged, must therefore have a post associated

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

        // photo isn't staged, must therefore have a post associated

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
     * Add a comment to this photo. This only works if the photo is published.
     *
     * @param Comment $comment
     */
    public function addComment(Comment $comment)
    {
        if($this->isPublished())
        {
            return $this->comments()->save($comment);
        }
        return false;
    }

    /**
     * return all photos that are not yet part of a post, published or not
     *
     */
    public function scopeStaged($query)
    {
        return $query->where('post_id', null);
    }


    /**
     * Order by the index_in_post.
     *
     * @param string $order Either 'asc' or 'desc'
     */
    public function scopeOrdered($query, $order = 'asc')
    {
        return $query->orderBy('index_in_post', $order);
    }


    /**
     * Delete the image file from the filesystem, the entry from the database, as
     * well as the associated comments.
     *
     */
    public function deleteCompletely()
    {
        Storage::delete($this->path);
        $this->comments()-delete();
        $this->delete();
    }

}
