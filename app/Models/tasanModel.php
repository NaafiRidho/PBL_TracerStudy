<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtasanModel extends Model
{
    use HasFactory;

    protected $table = 'atasan'; // nama tabel di database
    protected $primaryKey = 'atasan_id'; // primary key tabel
    public $timestamps = true; // jika tabel pakai created_at & updated_at

    protected $fillable = [
        'user_id',
        'nama_atasan',
        'nama_instansi',
        'jabatan',
        'email_atasan',
        'no_hp_atasan',
    ];
}
