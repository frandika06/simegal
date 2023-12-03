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
        Schema::create('tte_skhp', function (Blueprint $table) {
            $table->string('uuid', 100)->primary();
            $table->string('uuid_penjadwalan', 100)->nullable();
            $table->string('uuid_pejabat', 100)->nullable();
            $table->string('jabatan_pejabat', 100)->nullable();
            $table->string('kode_tte', 100)->unique();
            $table->dateTime('tanggal_generate')->nullable();
            $table->dateTime('tanggal_expired')->nullable();
            $table->dateTime('tanggal_acc')->nullable();
            $table->text('file_skhp')->nullable();
            $table->string('tipe', 100)->nullable();
            $table->integer('size')->default("0");
            $table->integer('views')->default("0");
            $table->integer('downloads')->default("0");
            $table->string('status_apps', 100)->nullable();
            $table->enum('status_acc', ["0", "1", "2"])->default("0"); // 0 = menunggu, 1 = acc, 2 = ditolak
            $table->enum('status_aktif', ["0", "1"])->default("0");
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
        Schema::dropIfExists('tte_skhp');
    }
};
