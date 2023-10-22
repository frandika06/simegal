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
        Schema::create('pdp_data_petugas', function (Blueprint $table) {
            $table->string('uuid', 100)->primary();
            $table->string('uuid_penjadwalan', 100)->nullable();
            $table->string('uuid_pegawai', 100)->nullable();
            $table->string('jabatan_petugas', 100)->nullable();
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
        Schema::dropIfExists('pdp_data_petugas');
    }
};
