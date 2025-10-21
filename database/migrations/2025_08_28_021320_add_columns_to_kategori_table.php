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
        Schema::table('kategori', function (Blueprint $table) {
            // Rename judul to nama for consistency
            $table->renameColumn('judul', 'nama');
            
            // Add new columns
            $table->text('deskripsi')->nullable()->after('nama');
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif')->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kategori', function (Blueprint $table) {
            // Remove added columns
            $table->dropColumn(['deskripsi', 'status']);
            
            // Rename back to judul
            $table->renameColumn('nama', 'judul');
        });
    }
};
