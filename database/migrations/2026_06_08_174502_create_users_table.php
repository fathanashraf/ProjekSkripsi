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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('NIM')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->string('No_hp')->nullable();
            $table->string('alamat')->nullable();
            $table->string('avatar')->nullable();
            $table->foreignId('role_id')->references('id')->on('roles')->onUpdate('restrict')->onDelete('restrict');
            $table->string('password');
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
