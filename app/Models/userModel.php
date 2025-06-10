<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class userModel extends Authenticatable
{
    use HasFactory;
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    protected $fillable = ['role_id', 'username', 'password'];
    protected $hidden = ['password']; // jangan ditampilkan saat select
    protected $casts = ['password' => 'hashed']; //casting password agar otomatis di hash

    public function role(): BelongsTo
    {
        return $this->belongsTo(roleModel::class, 'role_id', 'role_id');
    }
    public function alumni(): HasMany
    {
        return $this->hasMany(alumniModel::class, 'user_id', 'user_id');
    }
}
