<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasProjectScope;

class Signature extends Model
{
    use HasFactory, HasProjectScope;
    protected $guarded = [];

    public function decision()
    {
        return $this->belongsTo(Decision::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }
}
