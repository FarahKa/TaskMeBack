<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * Get the category of the task.
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    /**
     * Get the posts for the task.
     */
    public function posts()
    {
        return $this->hasMany('App\Post');
    //, 'task_id', 'id'
    }

}
