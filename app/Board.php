<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
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
     * The images that belong to the board.
     */
    public function images()
    {
        return $this->belongsToMany('App\Image');
    }

    /**
     * Get the user that owns the board.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}