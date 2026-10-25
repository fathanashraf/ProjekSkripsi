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
        Schema::create('keuangans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->nullable()->references('id')->on('users')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('acara_id')->references('id')->on('acaras')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('pembayaran_id')->references('id')->on('pembayarans')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('biaya_id')->references('id')->on('biayas')->onUpdate('restrict')->onDelete('restrict');
            $table->string('total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangans');
    }
};
