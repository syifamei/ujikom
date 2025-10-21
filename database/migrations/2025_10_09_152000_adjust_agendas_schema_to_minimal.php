<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('agendas')) {
            Schema::create('agendas', function (Blueprint $table) {
                $table->id();
                $table->text('description');
                $table->string('photo_path')->nullable();
                $table->enum('status', ['Aktif','Nonaktif'])->default('Aktif');
                $table->timestamps();
            });
            return;
        }

        Schema::table('agendas', function (Blueprint $table) {
            if (!Schema::hasColumn('agendas', 'description')) {
                $table->text('description');
            }
            if (!Schema::hasColumn('agendas', 'photo_path')) {
                $table->string('photo_path')->nullable();
            }
            if (!Schema::hasColumn('agendas', 'status')) {
                $table->enum('status', ['Aktif','Nonaktif'])->default('Aktif');
            }
            if (!Schema::hasColumn('agendas', 'created_at') || !Schema::hasColumn('agendas', 'updated_at')) {
                $table->timestamps();
            }

            // Drop legacy columns if present to avoid insert errors
            if (Schema::hasColumn('agendas', 'title')) {
                $table->dropColumn('title');
            }
            if (Schema::hasColumn('agendas', 'scheduled_at')) {
                $table->dropColumn('scheduled_at');
            }
        });
    }

    public function down(): void
    {
        // no-op; we keep data
    }
};




