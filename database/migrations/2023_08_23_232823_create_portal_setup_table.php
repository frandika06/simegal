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
        Schema::create('portal_setup', function (Blueprint $table) {
            $table->string('uuid', 100)->primary();
            $table->string('google_maps', 300)->nullable();
            $table->string('alamat', 300)->nullable();
            $table->string('no_telp', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('link_survey', 300)->nullable();
            $table->string('uuid_created', 100)->nullable();
            $table->string('uuid_updated', 100)->nullable();
            $table->string('uuid_deleted', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portal_setup');
    }
};
