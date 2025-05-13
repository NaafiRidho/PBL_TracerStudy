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
        Schema::create('alumni', function (Blueprint $table) {
            $table->id('alumni_id');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('atasan_id')->index();
            $table->unsignedBigInteger('jenis_instansi_id')->index();
            $table->unsignedBigInteger('kategori_profesi_id')->index();
            $table->unsignedBigInteger('profesi_id')->index();
            $table->string('nim',100);
            $table->string('nama_alumni');
            $table->string('prodi',100);
            $table->string('no_hp');
            $table->string('email');
            $table->date('tanggal_lulus');
            $table->date('tanggal_kerja_pertama');
            $table->unsignedBigInteger('masa_tunggu');
            $table->date('tanggal_mulai_instansi');
            $table->string('nama_instansi');
            $table->enum('skala_instansi',['international','nasional','wirausaha']);
            $table->string('lokasi_instansi');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('user');
            $table->foreign('atasan_id')->references('atasan_id')->on('atasan');
            $table->foreign('jenis_instansi_id')->references('jenis_instansi_id')->on('jenis_instansi');
            $table->foreign('kategori_profesi_id')->references('kategori_profesi_id')->on('kategori_profesi');
            $table->foreign('profesi_id')->references('profesi_id')->on('profesi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};
