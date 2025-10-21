<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('download_logs')) {
            return;
        }

        Schema::table('download_logs', function (Blueprint $table) {
            // Drop existing foreign key if exists, then make user_id nullable and set FK to set null
            try {
                $table->dropForeign(['user_id']);
            } catch (\Throwable $e) {}

            $table->unsignedBigInteger('user_id')->nullable()->change();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('download_logs')) {
            return;
        }

        Schema::table('download_logs', function (Blueprint $table) {
            try {
                $table->dropForeign(['user_id']);
            } catch (\Throwable $e) {}

            $table->unsignedBigInteger('user_id')->nullable(false)->default(0)->change();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->cascadeOnDelete();
        });
    }
};
















