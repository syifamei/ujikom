<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('agendas', function (Blueprint $table) {
            // Add missing columns
            if (!Schema::hasColumn('agendas', 'title')) {
                $table->string('title')->after('id');
            }
            if (!Schema::hasColumn('agendas', 'scheduled_at')) {
                $table->dateTime('scheduled_at')->nullable()->after('description');
            }
            if (!Schema::hasColumn('agendas', 'waktu')) {
                $table->string('waktu')->nullable()->after('scheduled_at');
            }
            if (!Schema::hasColumn('agendas', 'lokasi')) {
                $table->string('lokasi')->nullable()->after('waktu');
            }
        });
    }

    public function down(): void
    {
        Schema::table('agendas', function (Blueprint $table) {
            $table->dropColumn(['title', 'scheduled_at', 'waktu', 'lokasi']);
        });
    }
};
