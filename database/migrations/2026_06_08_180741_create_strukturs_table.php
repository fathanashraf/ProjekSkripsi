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
        Schema::create('strukturs', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')
        ->constrained('users')
        ->onUpdate('restrict')
        ->onDelete('restrict');

    $table->foreignId('devisi_id')
        ->nullable()
        ->constrained('devisis')
        ->onUpdate('restrict')
        ->onDelete('set null');

    $table->foreignId('jabatan_id')
        ->nullable()
        ->constrained('jabatans')
        ->onUpdate('restrict')
        ->onDelete('set null');

    $table->string('posisi')->nullable();

    $table->string('masa_jabatan')->nullable();
    $table->string('foto')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('strukturs');
    }
};
