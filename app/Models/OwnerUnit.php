<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasProjectScope;

class OwnerUnit extends Model
{
    use HasFactory, HasProjectScope;
    protected $table = 'owner_unit';
    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
