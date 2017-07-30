<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

use DB;

class Post extends Model
{

	// make all properties mass assignlable

	protected $guarded = [];


    public function photos()
    {
    	return $this->hasMany(App\Photo::class);
    }


    /**
     * Returns the current time according to the database
     *
     */
    private function currentTime()
    {
    	return Carbon::now('UTC');
    }


    /**
     * Check to see if this post is already published, meaning that the posts
     * publish_date lies in the past and the post is now visible to everyone.
     *
     */
    public function isPublished()
    {
    	return $this->publish_date <= $this->currentTime();
    }

    /**
     * Filter the query for published posts.
     *
     */
    public function scopePublished($query)
    {
    	return $query->where('publish_date', '<=', $this->currentTime())->latest('publish_date');
    }
}
