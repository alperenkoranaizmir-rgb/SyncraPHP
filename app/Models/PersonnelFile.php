<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonnelFile extends Model
{
    use HasFactory;

    protected $table = 'personel_dosyalari';

    protected $fillable = ['user_id','dosya_adi','dosya_turu','dosya_yolu','yukleyen_id','yuklenme_tarihi'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'yukleyen_id');
    }
}
