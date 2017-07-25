<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public function comments()
    {
    	return $this->hasMany('App\Comment');
    }

    public function post()
    {
    	return $this->belongsTo('App\Post');
    }


    // make all properties mass assignable

    protected $guarded = [];
}
