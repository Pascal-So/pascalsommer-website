<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	// allow mass assignment everywhere

    protected $guarded = [];


    /**
     * Get the parent tag
     *
     */
    public function parentTag()
    {
    	return $this->belongsTo(Tag::class, 'parent_tag_id');
    }

    /**
     * Get the direct descendents
     *
     */
    public function childrenTags()
    {
    	return $this->hasMany(Tag::class, 'parent_tag_id');
    }


    public function photos()
    {
    	return $this->belongsToMany(Photo::class);
    }
}

