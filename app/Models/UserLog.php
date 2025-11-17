<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;

    protected $table = 'user_logs';

    protected $fillable = ['user_id','islem_tipi','aciklama','ip','tarayici','tarih'];

    public $timestamps = true;

    protected $casts = [
        'tarih' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
