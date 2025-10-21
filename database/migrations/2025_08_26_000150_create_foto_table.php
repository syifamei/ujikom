<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('foto')) {
            return;
        }

        Schema::create('foto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('galery_id');
            $table->string('file');
            $table->string('judul');
            $table->timestamps();

            $table->foreign('galery_id')->references('id')->on('galery')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foto');
    }
};


