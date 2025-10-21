<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('agendas')) {
            Schema::table('agendas', function (Blueprint $table) {
                if (!Schema::hasColumn('agendas', 'title')) {
                    $table->string('title')->after('id');
                }
                if (!Schema::hasColumn('agendas', 'description')) {
                    $table->text('description')->nullable();
                }
                if (!Schema::hasColumn('agendas', 'photo_path')) {
                    $table->string('photo_path')->nullable();
                }
                if (!Schema::hasColumn('agendas', 'scheduled_at')) {
                    $table->dateTime('scheduled_at')->nullable();
                }
                if (!Schema::hasColumn('agendas', 'status')) {
                    $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
                }
                if (!Schema::hasColumn('agendas', 'created_at') && !Schema::hasColumn('agendas', 'updated_at')) {
                    $table->timestamps();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('agendas')) {
            Schema::table('agendas', function (Blueprint $table) {
                // No-op safe down to avoid dropping user data
            });
        }
    }
};




