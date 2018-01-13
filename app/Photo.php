<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;
use App\Comment;

class Photo extends Model
{
    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function prevPhoto(){
        $before_in_post = $this->post->photos->where('weight', '<', $this->weight);


        if($before_in_post->isEmpty()){
            $prevPost = $this->post->nextPost();
            if(isset($prevPost)){
                return $prevPost->photos->sortBy('weight')->last();
            }else{
                return null;
            }
        }else{
            return $before_in_post->sortBy('weight')->last();
        }
    }

    public function nextPhoto(){
        $after_in_post = $this->post->photos->where('weight', '>', $this->weight);

        if($after_in_post->isEmpty()){
            $nextPost = $this->post->prevPost();
            if(isset($nextPost)){
                return $nextPost->photos->sortBy('weight')->first();
            }else{
                return null;
            }
        }else{
            return $after_in_post->sortBy('weight')->first();
        }
    }
}
