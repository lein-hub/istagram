<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['images', 'post_id'];
    protected $cast = [
        'images' => 'array'
    ];

    // public function setImagesAttribute($images)
    // {
    //     $this->attributes['images'] = json_encode($images);
    // }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
