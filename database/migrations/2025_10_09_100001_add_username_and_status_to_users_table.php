<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->after('id');
            $table->string('phone')->nullable()->after('email');
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif')->after('password');
            $table->string('profile_photo_path', 2048)->nullable()->after('status');
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'phone',
                'status',
                'profile_photo_path',
                'deleted_at'
            ]);
        });
    }
};
