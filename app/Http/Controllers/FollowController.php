<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Follow;

class FollowController extends Controller
{
    private $follow;

    public function __construct(Follow $follow){
        $this->follow = $follow;
    }

    public function store($user_id){
        $this->follow -> follower_id = Auth::user()->id;
        $this->follow -> followed_id = $user_id;
        $this->follow -> save();

        return redirect()->back();
        //we are using back() b/c we can follow in multiple pages and going back is more flexible(can use this function in multiple pages)
    }

    public function delete($user_id){
        //look for what you added earlier in store() and delete it
        $this->follow->where('follower_id', Auth::user()->id)
                     ->where('followed_id', $user_id)
                     ->delete();
        return redirect()->back();
    }
}
