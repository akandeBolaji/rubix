<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class postVideo extends Model
{
    protected $table = 'post_videos';
    protected $fillable = ['path', 'post_id'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
