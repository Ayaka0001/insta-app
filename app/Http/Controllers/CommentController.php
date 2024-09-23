<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment){
        $this->comment = $comment;
    }

    public function store(Request $request,$post_id){
        $request->validate([
            'comment_body'.$post_id => 'required|max:150',
        ],
        [
            // to assign the error message. "the name of the input.the validation type" => "the error message"
            "comment_body$post_id.required" => "You cannot post an empty comment.",
            "comment_body$post_id.max" => "Maximum of 150 characters only",
        ]);

        $this->comment -> body = $request->input('comment_body'.$post_id);
        // when the name of the input has a variable, you need to use input('name of the input')
        $this->comment -> post_id = $post_id;
        $this->comment -> user_id = Auth::user()->id;
        $this->comment -> save();

        return redirect()->back();
    }

    public function delete($id){
        $this->comment->destroy($id);
        
        return redirect()->back();
    }
}
