<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryVideo extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'video_url', 'image_url']; // Ajout de 'image_url'
}
