<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'title', 'description', 'filename',
    ];

    /**
     * The boards that belong to the image.
     */
    public function boards()
    {
        return $this->belongsToMany('App\Board');
    }

    /**
     * Get the user that owns the image.
     */
    public function user()
    {
        return $this->belongsTo('App\Image');
    }

    /**
     * The users who possess the image.
     */
    public function users()
    {
        return $this->belongsToMany('App\Image');
    }

    /**
     * The tags that belong to the image.
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }
}
