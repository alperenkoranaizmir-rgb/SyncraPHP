<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasProjectScope;

class Signature extends Model
{
    use HasFactory, HasProjectScope;

    protected $fillable = [
        'decision_id','owner_id','signed','signed_at'
    ];

    protected $casts = [
        'signed' => 'boolean',
        'signed_at' => 'datetime',
    ];

    public function decision()
    {
        return $this->belongsTo(Decision::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
}
