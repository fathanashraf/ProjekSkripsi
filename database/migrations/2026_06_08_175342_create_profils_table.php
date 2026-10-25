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
        Schema::create('profils', function (Blueprint $table) {
            $table->id();
            $table->string('name_instansi')->nullable();
            $table->string('singkatan')->nullable();
            $table->longText('sejarah')->nullable();
            $table->string('alamat')->nullable();
            $table->string('logo')->nullable();
            $table->string('tahun_berdiri')->nullable();
            $table->string('visi')->nullable();
            $table->string('misi')->nullable();
            $table->string('tujuan')->nullable();
            $table->string('fungsi')->nullable();
            $table->string('ad_art')->nullable();
            $table->string('hymne_teknik')->nullable();
            $table->string('mars_mahasiswa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profils');
    }
};
