<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
     * Get the task.
     */
    public function post()
    {
        return $this->hasOne('App\Post');
    }
}
