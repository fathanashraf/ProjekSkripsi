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
        Schema::create('aspirasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->nullable()->references('id')->on('users')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('acaras_id')->nullable()->references('id')->on('acaras')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('beritas_id')->nullable()->references('id')->on('beritas')->onUpdate('restrict')->onDelete('restrict');
            $table->string('like')->nullable();
            $table->string('dislike')->nullable();
            $table->longText('Masukkan')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aspirasis');
    }
};
