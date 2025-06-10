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
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('atasan_id')->nullable()->index();
            $table->unsignedBigInteger('jenis_instansi_id')->nullable()->index();
            $table->unsignedBigInteger('kategori_profesi_id')->nullable()->index();
            $table->unsignedBigInteger('profesi_id')->nullable()->index();
            $table->string('nim',100)->nullable();
            $table->string('nama_alumni')->nullable();
            $table->string('prodi',100)->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();
            $table->date('tanggal_lulus')->nullable();
            $table->date('tanggal_kerja_pertama')->nullable();
            $table->unsignedBigInteger('masa_tunggu')->nullable();
            $table->date('tanggal_mulai_instansi')->nullable();
            $table->string('nama_instansi')->nullable();
            $table->enum('skala_instansi',['international','nasional','wirausaha'])->nullable();
            $table->string('lokasi_instansi')->nullable();
            $table->string('otp_code')->nullable(); // Kode OTP
            $table->boolean('isOtp')->default(false); //mengecek apakah otp sudah terpakai apa belum
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
