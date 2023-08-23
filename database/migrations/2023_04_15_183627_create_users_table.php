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
        Schema::create('users', function (Blueprint $table) {
            $table->string('uuid', 100)->primary();
            $table->string('uuid_profile', 100)->unique();
            $table->string('username', 100)->unique();
            $table->string('password', 255)->nullable();
            $table->rememberToken()->nullable();
            $table->string('role', 255)->nullable(); //SA / Peruahaan / Dinas
            $table->string('sub_role', 255)->nullable();
            $table->string('sub_sub_role', 255)->nullable();
            $table->enum('status', ["0", "1"])->default("1");
            $table->string('uuid_created', 100)->nullable();
            $table->string('uuid_updated', 100)->nullable();
            $table->string('uuid_deleted', 100)->nullable();
            $table->dateTime('last_seen')->nullable();
            $table->timestamps();
            $table->softdeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
