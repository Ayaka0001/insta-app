<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    //comment belongs to user
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    //comment belongs to post
    public function post(){
        return $this->belongsTo(Post::class);
    }
}
