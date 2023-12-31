<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysLogAktifitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_log_aktifitas', function (Blueprint $table) {
            $table->string('uuid', 100)->primary();
            $table->string('uuid_profile', 100)->nullable();
            $table->string('role', 100)->nullable();
            $table->string('apps', 255)->nullable();
            $table->string('subjek', 255)->nullable();
            $table->string('method', 100)->nullable();
            $table->string('ip', 100)->nullable();
            $table->string('agent', 255)->nullable();
            $table->text('url')->nullable();
            $table->json('aktifitas')->nullable();
            $table->enum('dashboard', ["0", "1"])->default(0);
            $table->enum('device', ['mobile', 'web'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_log_aktifitas');
    }
}
