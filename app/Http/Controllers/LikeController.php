<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;

class LikeController extends Controller
{
    private $like;

    public function __construct(Like $like){
        $this->like = $like;
    }

    public function store($post_id){
        $this->like->user_id = Auth::user()->id;
        $this->like->post_id = $post_id;
        $this->like->save();

        return redirect()->back();
    }

    public function delete($post_id){
        //look for what you added earlier in store() and delete it
        $this->like->where('user_id',Auth::user()->id)
                    ->where('post_id',$post_id)
                    ->delete();
        return redirect()->back();
    }
}
