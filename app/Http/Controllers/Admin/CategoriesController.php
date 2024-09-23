<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class CategoriesController extends Controller
{
    private $category;
    private $post;

    public function __construct(Category $category,Post $post){
        $this->category = $category;
        $this->post = $post;
    }

    public function index(){
        $all_categories = $this->category->latest('updated_at')->paginate(10);
        $all_posts = $this->post->all();
        $count=0;
        foreach($all_posts as $post){
            if($post->categoryPosts->count() == 0){ // if the post has no category
                $count++;
            }
        }

        return view('admin.categories.categories')->with('categories', $all_categories)
                                                  ->with('uncategorized_count', $count);      
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:50|unique:categories,name'
        ]);
        $this->category -> name = ucwords($request->name);
        $this->category -> save();

        return redirect()->back();
    }

    public function delete($id){
        $category_a = $this->category -> findOrFail($id);
        $category_a -> forceDelete();

        return redirect()->back();
    }

    public function update(Request $request,$id){
        $request->validate([
            "category$id" => 'required|max:50|unique:categories,name'.$id
        ],[
            "category$id.required" => "The name field is required.",
            "category$id.max" => "The name must not exceed 50 characters.",
            "category$id.unique" => "The new name has already been taken.",
        ]);
        $category_a = $this->category -> findOrFail($id);
        $category_a -> name = ucwords($request->input('category'.$id));
        $category_a -> save();

        return redirect()->back();
    }
}
