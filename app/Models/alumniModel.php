<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class alumniModel extends Authenticatable
{
    use HasFactory;
    protected $table = 'alumni';
    protected $primaryKey = 'alumni_id';
    protected $fillable = [
        'user_id',
        'atasan_id',
        'jenis_instansi_id',
        'kategori_profesi_id',
        'profesi_id',
        'nim',
        'nama_alumni',
        'prodi',
        'no_hp',
        'email',
        'tanggal_lulus',
        'tanggal_kerja_pertama',
        'masa_tunggu',
        'tangal_mulai_instansi',
        'nama_instansi',
        'skala_instansi',
        'lokasi_instansi',
        'otp_code',
        'isOtp',
    ];

    protected $casts = [
        'tanggal_lulus' => 'date',
        // kalau mau, bisa tambahkan tanggal lain juga:
        //'tanggal_kerja_pertama' => 'date',
    ];
    public function user()
    {
        return $this->belongsTo(userModel::class, 'user_id', 'user_id');
    }

    public function atasan()
    {
        return $this->belongsTo(AtasanModel::class, 'atasan_id', 'atasan_id');
    }
}
