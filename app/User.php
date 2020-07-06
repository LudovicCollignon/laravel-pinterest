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
     * Get the boards for the user.
     */
    public function images()
    {
        return $this->hasMany('App\Image');
    }
}
