<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{

    protected $primaryKey = 'user_id';
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
        return $this->hasMany('App\Post', 'worker_id', 'user_id');
    }
    /**
     * Get the ads he'll work on.
     */
    public function ads()
    {
        return $this->hasMany('App\Ad', 'worker_id', 'user_id');
    }

    /**
     * Get the categories = skills.
     */
    public function categories()
    {
        return $this->belongsToMany('App\Category', 'category_worker', "worker_id", "category_id");
    }
}
