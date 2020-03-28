<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * Get the tasks for the category.
     */
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }
}
