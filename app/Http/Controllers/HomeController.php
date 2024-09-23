<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;

class HomeController extends Controller
{
    private $post;
    private $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Post $post, User $user){
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request){
        if($request->search){ //if the request to the home page is coming form is coming from the search bar
            $home_posts = $this->post->latest()
                                     ->where('description', 'LIKE', '%'.$request->search.'%')
                                //search forposts where the description contains the search words
                                //SELECT * FROM posts WHERE description LIKE '%keyword%';
                                     ->get();
        }else{
            //get all posts with latest at the top of the list
            $all_posts = $this->post->latest()->get();

            //filter posts to only show auth user's posts AND followed user's posts
            $home_posts=[];
            foreach($all_posts as $post){
                if($post->user_id == Auth::user()->id || $post->user->isFollowed()){ //if the owner of the post is the logged in user OR the owner of the post is a followed user
                    $home_posts[] = $post; //add the post to the array $home_posts               
                }
            } 
        }
        return view('user.home')->with('all_posts', $home_posts) //pass the filtered posts to 'all_posts' variable
                                ->with('suggested_users', $this->getSuggestUsers())//gets us an array of suggested users and sends it to 'suggested_users'variable
                                ->with('search',$request->search); //pass the search variable to the view.if there is no search word, the variable will be null

    }

    //get 10 suggested users(not followed yet)
    public function getSuggestUsers(){ //we need this function b/c we can't use the isFollowed() function in the User Model
        $all_users = $this->user->all()->except(Auth::user()->id);
        //by adding except(Auth::user()->id), we get all the users except the logged in user
        //except needs an primary key : except(primary key)
        //we can exclude the logged in user from the suggested users by adding except(Auth::user()->id),or by adding an 条件 in the if statement 
        
        $suggested_users = []; //empty array
        $count = 0;
        foreach($all_users as $user){ //loop through all the users
            if(!$user->isFollowed() && $count<10){ //for all the users, check if they are not followed and if the count is less than 10
                $suggested_users[] = $user; //if they are not followed, add them to the array
                $count++; //each time an user is added, increment the count
            }
        }
        return $suggested_users;
    }

    public function suggestions(){
        $all_users = $this->user->all()->except(Auth::user()->id);
        $suggested_users = []; //empty array
        foreach($all_users as $user){ //loop through all the users
            if(!$user->isFollowed()){ //for all the users, check if they are not followed
            $suggested_users[] = $user; //if they are not followed, add them to the array
            }
        }
        
        return view('user.suggest')->with('suggested_users', $suggested_users);
    }

}
