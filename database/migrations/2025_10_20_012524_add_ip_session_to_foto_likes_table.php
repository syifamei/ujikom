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
            $table->string('ip_address')->nullable()->after('user_id');
            $table->string('session_id')->nullable()->after('ip_address');
            
            // Make user_id nullable for non-logged users
            $table->unsignedBigInteger('user_id')->nullable()->change();
            
            // Add unique constraints for IP and session
            $table->unique(['foto_id', 'ip_address'], 'unique_foto_ip_like');
            $table->unique(['foto_id', 'session_id'], 'unique_foto_session_like');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('foto_likes', function (Blueprint $table) {
            $table->dropUnique('unique_foto_ip_like');
            $table->dropUnique('unique_foto_session_like');
            $table->dropColumn(['ip_address', 'session_id']);
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }
};
