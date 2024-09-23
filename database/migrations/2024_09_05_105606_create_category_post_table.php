<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   //this is a pivot table for the relationship between categories and posts
    public function up(): void
    {
        Schema::create('category_post', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('category_id');
            
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            //onDelete('cascade') means that if a post is deleted, all the related category_posts will be deleted as well
            //use onDelete('cascade') on most of the foreign keys in the pivot table, b/c when we delete something,it may leave connections that are not needed
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_post');
    }
};
