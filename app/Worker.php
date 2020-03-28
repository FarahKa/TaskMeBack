<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the posts he'll work on.
     */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}
