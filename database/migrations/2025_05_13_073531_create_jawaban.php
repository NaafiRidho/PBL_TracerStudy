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
        Schema::create('jawaban', function (Blueprint $table) {
            $table->id('jawaban_id');
            $table->unsignedBigInteger('pertanyaan_id')->index();
            $table->unsignedBigInteger('alumni_id')->index();
            $table->unsignedBigInteger('atasan_id')->index();
            $table->text('jawaban');
            $table->timestamps();

            $table->foreign('pertanyaan_id')->references('pertanyaan_id')->on('pertanyaan');
            $table->foreign('alumni_id')->references('alumni_id')->on('alumni');
            $table->foreign('atasan_id')->references('atasan_id')->on('atasan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban');
    }
};
