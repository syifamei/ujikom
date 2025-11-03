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
        Schema::table('foto_likes', function (Blueprint $table) {
            // Drop the problematic IP and session unique constraints
            $table->dropUnique('unique_foto_ip_like');
            $table->dropUnique('unique_foto_session_like');
            
            // Keep only the user_id + foto_id unique constraint (already exists from first migration)
            // This allows one user to like a photo only once
            // Multiple users from same IP can like the same photo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('foto_likes', function (Blueprint $table) {
            // Restore the constraints if needed to rollback
            $table->unique(['foto_id', 'ip_address'], 'unique_foto_ip_like');
            $table->unique(['foto_id', 'session_id'], 'unique_foto_session_like');
        });
    }
};
