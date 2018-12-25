<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accomplishment extends Model
{
    protected $hidden = [];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
