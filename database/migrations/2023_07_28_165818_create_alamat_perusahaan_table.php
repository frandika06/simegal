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
        Schema::create('alamat_perusahaan', function (Blueprint $table) {
            $table->string('uuid', 100)->primary();
            $table->string('uuid_perusahaan', 100)->nullable();
            $table->string('label_alamat', 100)->nullable();
            $table->string('province_id', 100)->nullable();
            $table->string('regency_id', 100)->nullable();
            $table->string('district_id', 100)->nullable();
            $table->string('village_id', 100)->nullable();
            $table->string('alamat', 300)->nullable();
            $table->string('rt', 100)->nullable();
            $table->string('rw', 100)->nullable();
            $table->string('kode_pos', 100)->nullable();
            $table->string('lat', 100)->nullable();
            $table->string('long', 100)->nullable();
            $table->text('google_maps')->nullable();
            $table->enum('default', ["0", "1"])->default("0");
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
        Schema::dropIfExists('alamat_perusahaan');
    }
};
