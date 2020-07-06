<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The images that belong to the tag.
     */
    public function images()
    {
        return $this->belongsToMany('App\Image');
    }
}
