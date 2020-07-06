<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $primaryKey = 'user_id';
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
        return $this->belongsTo('App\User', 'id', 'user_id');
    }


    /**
     * Get the posts of the client.
     */
    public function posts()
    {
        return $this->hasMany('App\Post', 'client_id', 'user_id');
    }
    /**
     * Get the ads of the client.
     */
    public function ads()
    {
        return $this->hasMany('App\Ad', 'client_id', 'user_id');
    }
}
