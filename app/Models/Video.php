<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'views',
        'likes',
        'thumbnail_url',
        'video_url'
    ];

    protected $attributes = [
        'views' => 0,
        'likes' => 0
    ];
}