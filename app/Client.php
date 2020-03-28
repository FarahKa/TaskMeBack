<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }


    /**
     * Get the posts of the client.
     */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}
