<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanSurveiModel extends Model
{
    use HasFactory;
    protected $table = 'jawaban';
    protected $fillable = [
        'pertanyaan_id',  // atau 'id_pertanyaan' sesuai di DB
        'alumni_id',
        'atasan_id',
        'jawaban'         // atau 'nilai' sesuai nama kolom di tabel
    ];

}
