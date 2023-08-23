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
        Schema::create('master_kategori_kelompok', function (Blueprint $table) {
            $table->string('uuid', 100)->primary();
            $table->string('uuid_jp', 100)->nullable();
            $table->string('uuid_kelompok_uutp', 100)->nullable();
            $table->string('nama_kategori', 100)->nullable();
            $table->enum('kategori', ["0", "1", "2"])->default("1");
            $table->enum('status', ["0", "1"])->default("1");
            $table->string('uuid_created', 100)->nullable();
            $table->string('uuid_updated', 100)->nullable();
            $table->string('uuid_deleted', 100)->nullable();
            $table->timestamps();
            $table->softdeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_kategori_kelompok');
    }
};
