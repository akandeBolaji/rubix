<?php
namespace App;
use Eloquent;

class Profile extends Eloquent {

    protected $hidden = ['age', 'created_at', 'date_of_birth', 'updated_at'];
    //protected $primaryKey = 'id';
    protected $table = 'profiles';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
