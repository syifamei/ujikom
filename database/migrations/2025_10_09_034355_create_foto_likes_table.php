<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foto_likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('foto_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('foto_id')->references('id')->on('foto')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Ensure a user can only like a foto once
            $table->unique(['foto_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foto_likes');
    }
};