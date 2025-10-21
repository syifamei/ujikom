<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('posts', 'created_at')) {
                $table->timestamp('created_at')->useCurrent();
            }
            if (!Schema::hasColumn('posts', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Remove the columns if we need to rollback
            if (Schema::hasColumn('posts', 'created_at')) {
                $table->dropColumn('created_at');
            }
            if (Schema::hasColumn('posts', 'updated_at')) {
                $table->dropColumn('updated_at');
            }
        });
    }
};

























































