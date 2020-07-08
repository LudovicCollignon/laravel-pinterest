<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * Get the boards for the user.
     */
    public function boards()
    {
        return $this->hasMany('App\Board');
    }

    /**
     * Get the images uploaded by the user.
     */
    public function uploaded_images()
    {
        return $this->belongsToMany('App\Image');
    }

    /**
     * Get the images uploaded by the user.
     */
    public function images()
    {
        return $this->belongsToMany('App\Image');
    }

    /**
     * Get the followers of the user.
     */
    public function followers()
    {
        return $this->belongsToMany('App\User', 'user_user', 'followee_id', 'follower_id');

    }

    /**
     * Get the followees of the user.
     */
    public function followees()
    {
        return $this->belongsToMany('App\User', 'user_user', 'follower_id', 'followee_id');
    }

}
