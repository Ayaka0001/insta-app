<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\CategoriesController;

Auth::routes();

Route::group(['middleware' => ['auth']], function (){
                //middleware is a filter to only let certain people to access the routes
                //auth is specifically for logged in user
                //so, middleware->auth will only let logged in user to access the routes 
    Route::get('/', [HomeController::class, 'index'])->name('home');
    //suggestions
    Route::get('/suggested-users', [HomeController::class,'suggestions'])->name('suggestions');
    // posts
    Route::get('/post/create',[PostController::class, 'create'])->name('post.create');
    Route::post('/post/store',[PostController::class,'store'])->name('post.store');
    Route::get('/post/{id}/show', [PostController::class,'show'])->name('post.show');
    Route::get('/post/{id}/edit', [PostController::class,'edit'])->name('post.edit');
    Route::patch('/post/{id}/update', [PostController::class,'update'])->name('post.update');
    Route::delete('/post/{id}/delete', [PostController::class,'delete'])->name('post.delete');
    // comments
    Route::post('/comment/store/{post_id}', [CommentController::class,'store'])->name('comment.store');
    Route::delete('/comment/{id}/delete', [CommentController::class,'delete'])->name('comment.delete');
    //profile
    Route::get('/profile/{id}/show', [ProfileController::class,'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile/update',[ProfileController::class,'update'])->name('profile.update');
    Route::get('/profile/{id}/following', [ProfileController::class,'following'])->name('profile.following');
    Route::get('/profile/{id}/followers', [ProfileController::class,'followers'])->name('profile.followers');
    Route::patch('/profile/update-password',[ProfileController::class,'updatePassword'])->name('profile.update-password');
    //like
    Route::post('/like/{post_id}/store', [LikeController::class,'store'])->name('like.store');
    Route::delete('/like/{post_id}/delete', [LikeController::class,'delete'])->name('like.delete');
    //follow
    Route::post('/follow/{user_id}/store', [FollowController::class,'store'])->name('follow.store');
    Route::delete('/follow/{user_id}/delete', [FollowController::class,'delete'])->name('follow.delete');

    //admin
    Route::group(['middleware' => ['admin']], function () {
        //users
        Route::get('/admin/users', [UsersController::class,'index'])->name('admin.users');
        Route::delete('/admin/users/{id}/deactivate', [UsersController::class,'deactivate'])->name('admin.users.deactivate');
        Route::patch('/admin/users/{id}/activate', [UsersController::class,'activate'])->name('admin.users.activate');
        //posts
        Route::get('/admin/posts', [PostsController::class,'index'])->name('admin.posts');
        Route::delete('/admin/posts/{id}/hide', [PostsController::class,'hide'])->name('admin.posts.hide');
        Route::patch('/admin/posts/{id}/unhide', [PostsController::class,'unhide'])->name('admin.posts.unhide');
        //categories
        Route::get('/admin/categories', [CategoriesController::class,'index'])->name('admin.categories');
        Route::post('/admin/category/store', [CategoriesController::class,'store'])->name('admin.categories.store');
        Route::delete('/admin/category/{id}/delete', [CategoriesController::class,'delete'])->name('admin.categories.delete');
        Route::patch('/admin/category/{id}/edit', [CategoriesController::class,'update'])->name('admin.categories.edit');
    });
});