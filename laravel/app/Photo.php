<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;
use App\Comment;
use App\Tag;
use Illuminate\Support\Facades\Storage;

use JMauerhan\EloquentSortable\Sortable;
use JMauerhan\EloquentSortable\SortableTrait;

class Photo extends Model implements Sortable
{
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'weight',
        'sort_when_creating' => true,
        'sort_by_group_column' => 'post_id',
    ];
    
    protected $guarded = ['id'];

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

    public function scopePublished($query)
    {
        return $query->has('post');
    }

    public function scopeStaged($query)
    {
        return $query->doesntHave('post');
    }

    public function scopeBlogOrdered($query, bool $reverse = false)
    {
        $desc = $reverse ? 'asc' : 'desc';
        $asc = $reverse ? 'desc' : 'asc';

        return $query->orderByRaw('CASE WHEN post_id IS NULL THEN photos.weight + 1 ELSE 1 END DESC')
                    ->leftJoin('posts as p', 'photos.post_id', '=', 'p.id')
                    ->orderBy('p.date', $desc)
                    ->orderBy('p.id', $desc)
                    ->orderBy('weight', $asc)
                      // the explicit select statement is necessary, because otherwise, the
                      // photo id gets overwritten by the post id.
                    ->select(
                        'photos.id',
                        'photos.path',
                        'photos.description',
                        'photos.weight',
                        'photos.post_id',
                        'photos.created_at',
                        'photos.updated_at'
                    );
    }

    public function prevPhoto()
    {
        if (! $this->isPublic()) {
            return Photo::staged()
                        ->where('weight', '<', $this->weight)
                        ->orderBy('weight', 'desc')
                        ->first();
        }

        $before_in_post = $this->post->photos->where('weight', '<', $this->weight);

        if ($before_in_post->isEmpty()) {
            $prevPost = $this->post->nextPost();
            if (isset($prevPost)) {
                return $prevPost->photos->sortBy('weight')->last();
            }
            return null;
        }

        return $before_in_post->sortBy('weight')->last();
    }

    public function nextPhoto()
    {
        if (! $this->isPublic()) {
            return Photo::staged()
                        ->where('weight', '>', $this->weight)
                        ->orderBy('weight', 'asc')
                        ->first();
        }

        $after_in_post = $this->post->photos->where('weight', '>', $this->weight);

        if ($after_in_post->isEmpty()) {
            $nextPost = $this->post->prevPost();
            if (isset($nextPost)) {
                return $nextPost->photos->sortBy('weight')->first();
            }
            return null;
        }
    
        return $after_in_post->sortBy('weight')->first();
    }

    public function width():int
    {
        return getimagesize($this->path)[0];
    }

    public function height():int
    {
        return getimagesize($this->path)[1];
    }

    public function alttext():string
    {
        if ($this->description == "") {
            return "Photo by Pascal Sommer";
        }

        return "Photo by Pascal Sommer - " . $this->description;
    }

    public function getPaginationPage()
    {
        if (! $this->isPublic()) {
            return null;
        }

        return $this->post->getPaginationPage();
    }

    public function isPublic():bool
    {
        return $this->post !== null;
    }

    public function descriptionHTML():string
    {
        return nl2br(htmlspecialchars($this->description));
    }

    public function delete()
    {
        Storage::delete($this->path);

        $this->tags()->detach();

        $this->comments->each(function ($comment) {
            $comment->delete();
        });

        return parent::delete();
    }
}
