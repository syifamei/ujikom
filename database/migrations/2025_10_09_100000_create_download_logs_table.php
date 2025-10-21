<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('download_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('foto_id')->constrained('foto')->onDelete('cascade');
            $table->string('ip_address', 45);
            $table->text('user_agent')->nullable();
            $table->text('purpose')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('foto_id');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('download_logs');
    }
};
