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
        return $this->belongsTo('App\Post');
    }
    /**
     * Get the ad.
     */
    public function ad()
    {
        return $this->belongsTo('App\Ad');
    }


}
