<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{

    public function address()
    {
        return $this->belongsTo('App\Address');
    }

    /**
     * Get the client of the task.
     */
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
    /**
     * Get the worker of the task.
     */
    public function worker()
    {
        return $this->belongsTo('App\Worker');
    }
}
