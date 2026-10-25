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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('acara_id')->references('id')->on('acaras')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('pendaftaran_id')->references('id')->on('pendaftarans')->onUpdate('restrict')->onDelete('restrict');
            $table->string('status')->nullable();
            $table->string('jenis')->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
