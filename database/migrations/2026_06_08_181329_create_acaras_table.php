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
        Schema::create('acaras', function (Blueprint $table) {
            $table->id();
            $table->string('name_acara')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('tempat')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('thumnail')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('user_id')->references('id')->on('users')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('syarat_id')->references('id')->on('syarats')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('biaya_id')->references('id')->on('biayas')->onUpdate('restrict')->onDelete('restrict');
            $table->enum('tipe', ['internal', 'eksternal'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acaras');
    }
};
