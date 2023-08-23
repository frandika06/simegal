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
        Schema::create('portal_unduhan', function (Blueprint $table) {
            $table->string('uuid', 100)->primary();
            $table->string('nomor', 100)->nullable();
            $table->string('kategori_file', 100)->nullable();
            $table->text('judul')->nullable();
            $table->text('slug')->nullable();
            $table->text('deskripsi')->nullable();
            $table->dateTime('tanggal')->nullable();
            $table->text('url')->nullable();
            $table->string('tipe', 100)->nullable();
            $table->integer('size')->default("0");
            $table->integer('likes')->default("0");
            $table->integer('views')->default("0");
            $table->integer('downloads')->default("0");
            $table->string('status');
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
        Schema::dropIfExists('portal_unduhan');
    }
};
