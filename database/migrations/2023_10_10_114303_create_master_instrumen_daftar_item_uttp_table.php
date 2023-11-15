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
        Schema::create('master_instrumen_daftar_item_uttp', function (Blueprint $table) {
            $table->string('uuid', 100)->primary();
            $table->string('uuid_instrumen_jenis_uttp', 100)->nullable();
            $table->integer('no_urut')->nullable();
            $table->string('group_instrumen', 100)->nullable();
            $table->string('nama_instrumen', 100)->nullable();
            $table->integer('volume_from')->nullable();
            $table->integer('volume_to')->nullable();
            $table->integer('volume_per')->nullable();
            $table->string('satuan', 100)->nullable();
            $table->integer('tera_baru_pengujian')->nullable();
            $table->integer('tera_baru_pejustiran')->nullable();
            $table->integer('tera_ulang_pengujian')->nullable();
            $table->integer('tera_ulang_pejustiran')->nullable();
            $table->integer('tarif_per_jam')->nullable();
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
        Schema::dropIfExists('master_instrumen_daftar_item_uttp');
    }
};
