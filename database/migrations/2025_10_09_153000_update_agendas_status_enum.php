<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Map legacy values to new ones first
        try {
            DB::statement("UPDATE agendas SET status='Nonaktif' WHERE status IN ('Selesai','Dibatalkan')");
        } catch (\Throwable $e) {}

        // Change enum to only ('Aktif','Nonaktif')
        try {
            DB::statement("ALTER TABLE agendas MODIFY status ENUM('Aktif','Nonaktif') NOT NULL DEFAULT 'Aktif'");
        } catch (\Throwable $e) {}
    }

    public function down(): void
    {
        // Best-effort rollback to broader enum
        try {
            DB::statement("ALTER TABLE agendas MODIFY status ENUM('Aktif','Selesai','Dibatalkan') NOT NULL DEFAULT 'Aktif'");
        } catch (\Throwable $e) {}
    }
};




