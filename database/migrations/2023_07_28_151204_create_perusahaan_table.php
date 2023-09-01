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
        Schema::create('perusahaan', function (Blueprint $table) {
            $table->string('uuid', 100)->primary();
            $table->string('kode_perusahaan', 100)->unique();
            $table->string('jenis_perusahaan', 100)->nullable();
            $table->string('nama_perusahaan', 100)->nullable();
            $table->string('nama_pic', 100)->nullable();
            $table->string('npwp', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('no_telp_1', 100)->nullable();
            $table->string('no_telp_2', 100)->nullable();
            $table->text('file_npwp')->nullable();
            $table->enum('verifikasi', ["0", "1"])->default("0");
            $table->enum('status', ["0", "1"])->default("1");
            $table->string('uuid_verifikasi', 100)->nullable();
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
        Schema::dropIfExists('perusahaan');
    }
};
