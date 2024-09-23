<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Post; //connection to posts table

class PostController extends Controller{

    private $category;
    private $post;

    public function __construct(Category $category, Post $post){
        $this->category = $category;
        $this->post = $post; //=> $post = new Post; 
        //makes connection to table and makes new empty row
    }

    public function create(){
        $all_categories = $this->category->all(); //getting all categories

        return view('user.posts.create')->with('all_categories', $all_categories);
    }

    public function store(Request $request){
        $request->validate([
            'categories' => 'required|array|between:1,3', 
            //the checkboxes 
            //array: returns an array 
            //between depends on what it is used with, but when used with array, it means the number of value in the array must be between 1 and 3
            'description' => 'required|max:1000',
            //max for strings is the maximum number of characters
            'image' => 'required|max:1048|mimes:jpg,jpeg,png,gif',
            //max for images is the file size in KB
        ]);

        $this->post -> description = $request->description;
        $this->post -> image =  "data:image/".$request->image->extension().";base64,".base64_encode(file_get_contents($request->image));
        //this time the data type for image is longText
        //this is how to convert image to longtext
        // .$request->image->extension() => $request->imput name-> extension
        //if image files are stored in a temporary folder, you don't have to get the image every time to show it
        //if you dont have to store the images temporarily it is faster to store them in the database 
        $this->post -> user_id = Auth::user()->id;
        $this->post->save();

        //save categories
        $category_posts = []; //empty array
        foreach($request->categories as $category_id){
                //array of checked checkboxes
            $category_posts[] = ['category_id' => $category_id];
            //add category id to the array
            //if 1&2 are checked, category_posts will be look like this: $category_posts = [['category_id' => 1], ['category_id' => 2]]
        }
        $this->post->categoryPosts()->createMany($category_posts);
        //with this method we can add all the categories in one line
        //createMany is a mass version of the create function
        //each of the small array in the array will be added as one row in the table

        //using createMany to put the $category_posts array into the category_posts table-> use the relationship categoryPosts() to connect between posts and categories and use the post_id from $this->post to store id

        //redirect to home
        return redirect()->route('home');
    }

    public function show($id){
        $post_a = $this->post->findOrFail($id);
        return view('user.posts.show')->with('post', $post_a);
    }

    public function edit($id){
      $post_a = $this->post->findOrFail($id);
      $all_categories = $this->category->all();

      if(Auth::user()->id != $post_a->user_id){
          return redirect()->route('home');
      }

      $selected_categories=[];
      foreach($post_a->categoryPosts as $category_post){
          $selected_categories[] = $category_post->category_id;
      }

      return view('user.posts.edit')->with('post', $post_a)
                                    ->with('all_categories', $all_categories)
                                    ->with('selected_categories', $selected_categories);
    }

    public function update(Request $request, $id){
        $request->validate([
            'categories' => 'required|array|between:1,3', 
            'description' => 'required|max:1000',
            'image' => 'max:1048|mimes:jpg,jpeg,png,gif',
        ]);
        $post_a = $this->post->findOrFail($id);

        $post_a->description = $request->description;
        if($request->image){
            $post_a->image = "data:image/".$request->image->extension().";base64,".base64_encode(file_get_contents($request->image));
        }
        $post_a->save();

        //updating category_posts
        $post_a->categoryPosts()->delete(); //first delete all the old category_posts connected to the post
        //delete()function deletes whatever is on the left

        //save categories
        $category_posts = []; 
        foreach($request->categories as $category_id){
            $category_posts[] = ['category_id' => $category_id];
        }
        $post_a->categoryPosts()->createMany($category_posts);
        //the post id will come from $post_a

        return redirect()->route('post.show', $id);
    }

    public function delete($id){
        // $this->post->destroy($id);
        // b/c we applied soft delete in admin, this will become a soft delete as well so we need to change it to force delete
        $post_a = $this->post->findOrFail($id);
        $post_a->forceDelete(); //permanent delete
        
        return redirect()->route('home');
    }
}
