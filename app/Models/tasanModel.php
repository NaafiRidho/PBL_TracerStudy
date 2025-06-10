<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\alumniModel; // Pastikan ini sesuai dengan namespace model alumni

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

    public function alumniUser()
    {
        return $this->belongsTo(AlumniModel::class, 'user_id', 'user_id');
    }
    public function alumni()
    {
        return $this->hasOne(AlumniModel::class, 'atasan_id'); // atau foreign key yang sesuai
    }
}
