<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertanyaanModel extends Model
{
    protected $table = 'pertanyaan';
    protected $primaryKey = 'pertanyaan_id';
    public $timestamps = true;

    protected $fillable = [
        'pertanyaan'
    ];
}
