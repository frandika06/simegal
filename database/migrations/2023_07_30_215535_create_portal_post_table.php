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
        Schema::create('portal_post', function (Blueprint $table) {
            $table->string('uuid', 100)->primary();
            $table->text('judul')->nullable();
            $table->text('slug')->nullable();
            $table->text('deskripsi')->nullable();
            $table->longText('post')->nullable();
            $table->string('kategori', 100)->nullable();
            $table->text('thumbnails')->nullable();
            $table->dateTime('tanggal')->nullable();
            $table->integer('views')->default("0");
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
        Schema::dropIfExists('portal_post');
    }
};
