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
        Schema::create('pdp_alat', function (Blueprint $table) {
            $table->string('uuid', 100)->primary();
            $table->string('uuid_penjadwalan', 100)->nullable();
            $table->string('uuid_alat', 100)->nullable();
            $table->integer('no_urut')->default(1);
            $table->integer('jumlah_unit')->default(0);
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
        Schema::dropIfExists('pdp_alat');
    }
};
