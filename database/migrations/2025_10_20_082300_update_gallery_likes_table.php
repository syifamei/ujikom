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
        Schema::table('gallery_likes', function (Blueprint $table) {
            // Drop existing foreign key constraints and indexes
            $table->dropForeign(['gallery_item_id']);
            $table->dropUnique('unique_user_like');
            $table->dropUnique('unique_ip_like');
            $table->dropUnique('unique_session_like');
            
            // Rename the column
            $table->renameColumn('gallery_item_id', 'foto_id');
            
            // Add new foreign key constraint
            $table->foreign('foto_id')->references('id')->on('foto')->onDelete('cascade');
            
            // Recreate the unique constraints with the new column name
            $table->unique(['foto_id', 'user_id'], 'unique_user_like');
            $table->unique(['foto_id', 'ip_address'], 'unique_ip_like');
            $table->unique(['foto_id', 'session_id'], 'unique_session_like');
            
            // Remove the type column since we're not using dislike anymore
            $table->dropColumn('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gallery_likes', function (Blueprint $table) {
            // Drop the new constraints
            $table->dropForeign(['foto_id']);
            $table->dropUnique('unique_user_like');
            $table->dropUnique('unique_ip_like');
            $table->dropUnique('unique_session_like');
            
            // Rename back to the original column name
            $table->renameColumn('foto_id', 'gallery_item_id');
            
            // Add back the type column
            $table->enum('type', ['like', 'dislike'])->default('like');
            
            // Recreate the original foreign key and constraints
            $table->foreign('gallery_item_id')->references('id')->on('gallery_items')->onDelete('cascade');
            $table->unique(['gallery_item_id', 'user_id'], 'unique_user_like');
            $table->unique(['gallery_item_id', 'ip_address'], 'unique_ip_like');
            $table->unique(['gallery_item_id', 'session_id'], 'unique_session_like');
        });
    }
};
