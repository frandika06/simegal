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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->string('uuid', 100)->primary();
            $table->string('nama_lengkap', 100)->nullable();
            $table->string('nip', 100)->nullable();
            $table->string('pangkat_golongan', 100)->nullable();
            $table->string('jabatan', 100)->nullable();
            $table->enum('jenis_kelamin', ["L", "P"])->default("L");
            $table->string('email', 100)->nullable();
            $table->string('no_telp', 100)->nullable();
            $table->text('foto')->nullable();
            $table->string('status_pegawai', 100)->nullable();
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
        Schema::dropIfExists('pegawai');
    }
};
