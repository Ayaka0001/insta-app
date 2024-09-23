<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    //post belongs to user
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    //post has many category_posts
    public function categoryPosts(){
        return $this->hasMany(CategoryPost::class);
    }

    //post has many comments
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    //post has many likes(to show how many people liked the post)
    public function likes(){
        return $this->hasMany(Like::class);
    }

    //return true if the post is liked by logged-in user
    public function isLiked(){
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
        // look at the post-> get the list of likes-> look for the list of likes that belongs to the logged in user(look at user_id column and find the row with Auth::user()->id)
        //$this->likes()--> get the post's likes
        //where()--> in the list of likes, look for logged-in user
        //exists()--> if where() finds records, return true
    }
}
