<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // MySQL ENUM cannot be altered via standard Schema builder;
        // we use a raw query to modify the column's allowed values.
        DB::statement("ALTER TABLE `laporans` MODIFY COLUMN `jenis` ENUM('proposal', 'lpj', 'sk', 'lengkap') NULL DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE `laporans` MODIFY COLUMN `jenis` ENUM('proposal', 'lpj', 'sk') NULL DEFAULT NULL");
    }
};
