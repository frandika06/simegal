<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysLoginTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_login', function (Blueprint $table) {
            $table->string('uuid', 100)->primary();
            $table->string('uuid_profile', 100)->nullable();
            $table->string('status', 100)->nullable();
            $table->string('ip', 100)->nullable();
            $table->string('agent', 255)->nullable();
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
        Schema::dropIfExists('sys_login');
    }
}
