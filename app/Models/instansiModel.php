<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class instansiModel extends Model
{
    use HasFactory;
    protected $table = 'jenis_instansi';
    protected $primaryKey = 'jenis_instansi_id';
    protected $fillable = [
        'jenis_instansi',
    ];
}
