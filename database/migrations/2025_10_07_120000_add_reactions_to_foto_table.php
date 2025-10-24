<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('foto', function (Blueprint $table) {
            if (!Schema::hasColumn('foto', 'likes_count')) {
                $table->unsignedBigInteger('likes_count')->default(0)->after('status');
            }
            if (!Schema::hasColumn('foto', 'dislikes_count')) {
                $table->unsignedBigInteger('dislikes_count')->default(0)->after('likes_count');
            }
        });
    }

    public function down(): void
    {
        Schema::table('foto', function (Blueprint $table) {
            if (Schema::hasColumn('foto', 'dislikes_count')) {
                $table->dropColumn('dislikes_count');
            }
            if (Schema::hasColumn('foto', 'likes_count')) {
                $table->dropColumn('likes_count');
            }
        });
    }
};









































