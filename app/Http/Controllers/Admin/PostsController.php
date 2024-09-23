<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostsController extends Controller
{

    private $post;

    public function __construct(Post $post){
        $this->post = $post;
    }

    public function index(Request $request){
        if($request->search){ //if the request to the page is coming form is coming from the search bar
            $all_posts = $this->post->withTrashed()
                                     ->latest()
                                     ->where('description', 'LIKE', '%'.$request->search.'%') //search forposts where the description contains the search words //SELECT * FROM posts WHERE description LIKE '%keyword%';
                                     ->paginate(10);
        }else{
            $all_posts = $this->post->withTrashed()->latest()->paginate(10);
        }

        return view('admin.posts.posts')->with('posts', $all_posts)
                                         ->with('search', $request->search);
    }

    public function hide($id){
        $this->post -> destroy($id);
        //destroy(id) means that we will delete the post with the given id
        //b/c the posts table has soft delete attribute, this destroy will delete the post temporarily
        return redirect()->back();
    }

    public function unhide($id){
        $this->post -> onlyTrashed() -> findOrFail($id) -> restore();
        //we need onlyTrashed() to show only soft-deleted records.(if we don't use this, we wil get an error b/c the user is soft-deleted and can not be found)
        //restore() means that we will restore the user that was found by findOrFail(id)
        //b/c the users table has soft delete attribute, this restore will restore the user
        return redirect()->back();
    }
}
