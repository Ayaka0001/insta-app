<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    //category has many category_posts
    public function categoryPosts(){
        return $this->hasMany(CategoryPost::class);
    }
}
