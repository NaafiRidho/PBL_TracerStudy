<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AtasanModel extends Authenticatable
{
    use HasFactory;

    protected $table = 'atasan';
    protected $primaryKey = 'atasan_id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'nama_atasan',
        'nama_instansi',
        'jabatan',
        'email_atasan',
        'no_hp_atasan',
    ];

    public function alumni()
    {
        return $this->hasMany(AlumniModel::class, 'atasan_id', 'atasan_id');
    }
}
