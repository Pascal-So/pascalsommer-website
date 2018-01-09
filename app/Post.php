<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Photo;

class Post extends Model
{
    public function photos(){
    	return $this->hasMany(Photo::class);
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
}
