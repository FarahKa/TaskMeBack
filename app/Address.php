<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * Get the post.
     */
    public function post()
    {
        return $this->hasOne('App\Post');
    }

    /**
     * Get the ad.
     */
    public function Ad()
    {
        return $this->hasOne('App\Ad');
    }
}
