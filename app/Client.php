<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'cin', 'phone_number', 'rating'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }


    /**
     * Get the posts of the client.
     */
    public function posts()
    {
        return $this->hasMany('App\Post', 'user_id', 'client_id');
    }
}
