<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'izinler';

    protected $fillable = ['izin_adi','aciklama','aktif'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'rol_izin', 'izin_id', 'rol_id');
    }
}
