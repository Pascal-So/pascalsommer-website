<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;
use App\Comment;
use App\Tag;

class Photo extends Model
{
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function prevPhoto()
    {
        $before_in_post = $this->post->photos->where('weight', '<', $this->weight);


        if($before_in_post->isEmpty()){
            $prevPost = $this->post->nextPost();
            if(isset($prevPost)){
                return $prevPost->photos->sortBy('weight')->last();
            }
            return null;
        }

        return $before_in_post->sortBy('weight')->last();
    }

    public function nextPhoto()
    {
        $after_in_post = $this->post->photos->where('weight', '>', $this->weight);

        if($after_in_post->isEmpty()){
            $nextPost = $this->post->prevPost();
            if(isset($nextPost)){
                return $nextPost->photos->sortBy('weight')->first();
            }
            return null;
        }
    
        return $after_in_post->sortBy('weight')->first();
    }

    public function decreaseWeight()
    {
        $in_post = $this->post->photos;

        $weights = $in_post->pluck('weight')->sort();
        $weight = $this->weight;

        $smaller_weight = $weights->last(function($value, $key)use($weight){return $value < $weight;});

        if(!isset($smaller_weight)){
            return;
        }

        $smaller = self::where('weight', $smaller_weight)->first();

        $smaller->weight = $this->weight;
        $this->weight = $smaller_weight;

        $this->save();
        $smaller->save();
    }

    public function increaseWeight()
    {
        $in_post = $this->post->photos;

        $weights = $in_post->pluck('weight')->sort();
        $weight = $this->weight;

        $bigger_weight = $weights->first(function($value, $key)use($weight){return $value > $weight;});

        if(!isset($bigger_weight)){
            return;
        }

        $bigger = self::where('weight', $bigger_weight)->first();

        $bigger->weight = $this->weight;
        $this->weight = $bigger_weight;

        $this->save();
        $bigger->save();
    }

    public function alttext()
    {
        if($this->description == ""){
            return "Photo by Pascal Sommer";
        }

        return "Photo by Pascal Sommer - " . $this->description;
    }
}
