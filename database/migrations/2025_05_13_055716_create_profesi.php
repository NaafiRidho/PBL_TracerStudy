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
        Schema::create('profesi', function (Blueprint $table) {
            $table->id('profesi_id');
            $table->unsignedBigInteger('kategori_profesi_id')->index();
            $table->string('profesi');
            $table->timestamps();

            $table->foreign('kategori_profesi_id')->references('kategori_profesi_id')->on('kategori_profesi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profesi');
    }
};
