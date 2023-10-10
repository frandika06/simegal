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
        Schema::create('master_instrumen_jenis_uttp', function (Blueprint $table) {
            $table->string('uuid', 100)->primary();
            $table->integer('no_urut')->nullable();
            $table->string('nama_jenis_uttp', 100)->nullable();
            $table->enum('status_volume', ["0", "1"])->default("1");
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
        Schema::dropIfExists('master_instrumen_jenis_uttp');
    }
};
