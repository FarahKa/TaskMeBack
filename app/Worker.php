<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'cin', 'phone_number', 'verified', 'rating'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    /**
     * Get the posts he'll work on.
     */
    public function posts()
    {
        return $this->hasMany('App\Post', 'user_id', 'worker_id');
    }

    /**
     * Get the categories = skills.
     */
    public function categories()
    {
        return $this->hasMany('App\Category', 'user_id', 'id');
    }
}
