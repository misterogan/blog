<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = ['title', 'content', 'author_id', 'published_date', 'status', 'likes', 'dislikes'];


}


