<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function photo()
    {
    	$this->belongsTo(App\Photo::class);
    }
}
