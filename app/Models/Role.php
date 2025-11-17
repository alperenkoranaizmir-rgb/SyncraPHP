<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roller';

    protected $fillable = ['rol_adi','rol_aciklama','aktif'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'rol_izin', 'rol_id', 'izin_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role', 'rol_id', 'user_id');
    }
}
