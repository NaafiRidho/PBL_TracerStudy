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
        Schema::create('atasan', function (Blueprint $table) {
            $table->id('atasan_id');
            $table->unsignedBigInteger('user_id')->index();
            $table->string('nama_atasan',50);
            $table->string('nama_instansi',100);
            $table->string('jabatan',50);
            $table->string('email_atasan');
            $table->string('no_hp_atasan');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atasan');
    }
};
