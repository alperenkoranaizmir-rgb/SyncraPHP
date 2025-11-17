<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasProjectScope;

class OwnerUnit extends Model
{
    use HasFactory, HasProjectScope;

    protected $table = 'owner_unit';

    protected $fillable = [
        'owner_id','unit_id','share_percent','owner_type'
    ];

    protected $casts = [
        'share_percent' => 'decimal:2'
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
