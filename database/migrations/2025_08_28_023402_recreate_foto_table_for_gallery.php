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
        // Drop existing table
        Schema::dropIfExists('foto');
        
        // Create new foto table with correct structure
        Schema::create('foto', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('path'); // For file path
            $table->unsignedBigInteger('kategori_id');
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->unsignedBigInteger('petugas_id')->nullable();
            $table->timestamps();
            
            // Add foreign key constraints later
            // $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('cascade');
            // $table->foreign('petugas_id')->references('id')->on('petugas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop new table
        Schema::dropIfExists('foto');
        
        // Recreate old table structure
        Schema::create('foto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('galery_id');
            $table->string('file');
            $table->string('judul');
            $table->timestamps();
            
            $table->foreign('galery_id')->references('id')->on('galery')->onDelete('cascade');
        });
    }
};
