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
        Schema::create('permohonan', function (Blueprint $table) {
            $table->string('uuid', 100)->primary();
            $table->string('uuid_perusahaan', 100)->nullable();
            $table->integer('nomor')->default('1');
            $table->string('kode', 100)->nullable();
            $table->integer('bulan')->nullable();
            $table->year('tahun')->nullable();
            $table->string('nomor_permohonan', 100)->unique();
            $table->string('jenis_pengujian', 100)->nullable();
            $table->string('nomor_surat_permohonan', 100)->nullable();
            $table->text('file_surat_permohonan')->nullable();
            $table->date('tanggal_permohonan')->nullable();
            $table->string('lokasi_peneraan', 100)->nullable();
            $table->string('uuid_alamat', 100)->nullable();
            $table->enum('status', ['Baru', 'Diproses', 'Ditolak', 'Selesai'])->default('Baru'); // 'Baru', 'Diproses', 'Ditolak', 'Selesai'
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
        Schema::dropIfExists('permohonan');
    }
};
