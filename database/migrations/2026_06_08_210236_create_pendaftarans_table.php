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
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pendaftar')->nullable();
            $table->string('NO_HP')->nullable();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('acaras_id')->references('id')->on('acaras')->onUpdate('restrict')->onDelete('restrict');
            $table->string('status')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};
