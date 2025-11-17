<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasProjectScope;

class Decision extends Model
{
    use HasFactory, HasProjectScope;
    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function signatures()
    {
        return $this->hasMany(Signature::class);
    }
}
