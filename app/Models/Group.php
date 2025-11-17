<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table = 'gruplar';

    protected $fillable = ['grup_adi','aciklama','aktif'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_group', 'grup_id', 'user_id');
    }
}
