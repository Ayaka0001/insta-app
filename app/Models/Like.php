<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    public $timestamps = false; 
    //do not save timestamps 
    //usually add this to pivot table 


    //like belongs to user(to show who liked the post)
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }
}
