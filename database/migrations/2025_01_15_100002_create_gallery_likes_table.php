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
        Schema::create('gallery_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_item_id')->constrained('gallery_items')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('ip_address')->nullable();
            $table->string('session_id')->nullable();
            $table->enum('type', ['like', 'dislike']);
            $table->timestamps();
            
            // Ensure one user/IP/session can only like/dislike one gallery item once
            $table->unique(['gallery_item_id', 'user_id'], 'unique_user_like');
            $table->unique(['gallery_item_id', 'ip_address'], 'unique_ip_like');
            $table->unique(['gallery_item_id', 'session_id'], 'unique_session_like');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_likes');
    }
};


