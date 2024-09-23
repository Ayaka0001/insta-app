<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;

    protected $table = 'category_post'; //telling laravel the table name is 'category_post'(singular)
    public $timestamps = false; //do not save timestamps //usually add this to pivot table 
    protected $fillable = ['category_id', 'post_id'];//needed for create() of createMany()
                                                     //allowable columns in the inserted array
                                                     //is not something needed for all pivot table, but needed for this one

      //category_post belongs to category
      public function category(){
        return $this->belongsTo(Category::class);
    }

    //category_post belongs to post
    public function post(){
        return $this->belongsTo(Post::class);
    }
}
