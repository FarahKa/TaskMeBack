<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function address()
    {
        //return $this->belongsTo('App\Address', 'address_id', 'id');
        return $this->belongsTo('App\Address');
    }

    /**
     * Get the client of the task.
     */
    public function client()
    {
        return $this->belongsTo('App\Client', 'client_id', 'user_id');
    }
    /**
     * Get the worker of the task.
     */
    public function worker()
    {
        return $this->belongsTo('App\Worker');
        //, 'worker_id', 'user_id'
    }
    /**
     * Get the task of the post.
     */
    public function task()
    {
        return $this->belongsTo('App\Task');
        //, 'id', 'task_id'
    }


}
