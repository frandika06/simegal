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
        Schema::create('pdp_retribusi', function (Blueprint $table) {
            $table->string('uuid', 100)->primary();
            $table->string('uuid_penjadwalan', 100)->nullable();
            $table->bigInteger('total_retribusi')->nullable();
            $table->dateTime('tgl_skrd')->nullable();
            $table->dateTime('tgl_jatuh_tempo')->nullable();
            $table->string('kode_bayar_webr', 100)->nullable();
            $table->text('file_pembayaran')->nullable();
            $table->dateTime('tgl_upload')->nullable();
            $table->dateTime('tgl_verifikasi')->nullable();
            $table->enum('status', ['Unpaid', 'Paid', 'Declined']);
            $table->string('uuid_generate_skrd', 100)->nullable();
            $table->string('uuid_verifikasi', 100)->nullable();
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('pdp_retribusi');
    }
};
