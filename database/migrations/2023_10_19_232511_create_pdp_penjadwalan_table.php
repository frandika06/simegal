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
        Schema::create('pdp_penjadwalan', function (Blueprint $table) {
            $table->string('uuid', 100)->primary();
            $table->string('uuid_permohonan', 100)->nullable();
            $table->string('uuid_kelompok_uutp', 100)->nullable();
            $table->string('nomor_order', 100)->unique();
            $table->date('tanggal_peneraan')->nullable();
            $table->time('jam_peneraan')->nullable();
            $table->string('nama_supir', 100)->nullable();
            $table->string('jenis_kendaraan', 100)->nullable();
            $table->string('plat_nomor_kendaraan', 100)->nullable();
            $table->string('status_peneraan', 100)->nullable();
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
        Schema::dropIfExists('pdp_penjadwalan');
    }
};
