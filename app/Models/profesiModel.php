<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class profesiModel extends Model
{
    use HasFactory;
    protected $table = 'profesi';
    protected $primaryKey ='profesi_id';
    protected $fillable = ['kategori_profesi_id','profesi'];

    public function kategori_profesi(): BelongsTo{
        return $this->belongsTo(Kategori_porfesiModel::class,'kategori_profesi_id','kategori_profesi_id');
    }
}
