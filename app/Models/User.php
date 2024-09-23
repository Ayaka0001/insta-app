<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    const ADMIN_ROLE_ID = 1;
    const USER_ROLE_ID = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //user has manu posts
    public function posts(){
        return $this->hasMany(Post::class)->latest();
    }

    //user follows many users(user has many follows)
    public function follows(){
        return $this->hasMany(Follow::class,'follower_id');
    }
    //laravel uses the names of the foreign keys to find the relationships 
    //if we have has many connection, laravel will look for user_id, but this time we dont have user_id in the follow table
    //so we need to specify the foreign key
    //we need to specify the foreign key the standard foreign key id name is not in the table 

    //user is followed by many users(user has many followers)
    public function followers(){
        return $this->hasMany(Follow::class,'followed_id');
    }
    
    public function isFollowed(){
        return $this->followers()->where('follower_id',Auth::user()->id)->exists();
        //follwers() is from the followed user to the pivot table
        //by calling the followers() function, we get the information about the users that are following the profile user
        //from there we get the data where the followed_id(the user following the profile user) is equal to the logged in user

        //$this->followers() -->get list of $this user's followers(people that are following this user)
        //where() --> among the follwers, find logged in user
        //exists() --> return true if where() found rows
    }

    public function followsYou(){
        return $this->follows()->where('followed_id',Auth::user()->id)->exists();
    }

    //user has many comments
    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
