<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class atasanModel extends Model
{
    use HasFactory;
    // Nama tabel jika tidak mengikuti konvensi plural
    protected $table = 'atasan';

    // Primary key bukan 'id', jadi perlu didefinisikan
    protected $primaryKey = 'atasan_id';

    // Jika primary key bukan auto-increment integer, tambahkan:
    // public $incrementing = true;
    // protected $keyType = 'int';

    // Field yang boleh diisi mass-assignment
    protected $fillable = [
        'user_id',
        'nama_atasan',
        'nama_instansi',
        'jabatan',
        'email_atasan',
        'no_hp_atasan',
        'otp_code',
        'isOtp'
    ];

    // Relasi ke tabel user (asumsinya modelnya User)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
