<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class postImage extends Model
{
    protected $table = 'post_images';
    protected $fillable = ['path', 'post_id'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
