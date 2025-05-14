<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Kategori_porfesiModel extends Model
{
    use HasFactory;
    protected $table = 'kategori_profesi';
    protected $primaryKey = 'kategori_profesi_id';
    protected $fillable = ['kategori_profesi'];

    public function profesi(): HasMany
    {
        return $this->hasMany(profesiModel::class, 'profesi_id', 'profesi_id');
    }
}
