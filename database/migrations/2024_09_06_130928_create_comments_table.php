<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('body',150);
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            // cascade => if the post is deleted, all comments will be deleted
            $table->foreign('user_id')->references('id')->on('users');
            // we are not going to delete users, so we don't need to specify onDelete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
