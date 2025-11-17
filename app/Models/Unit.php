<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasProjectScope;

class Unit extends Model
{
    use HasFactory, HasProjectScope;
    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function ownerUnits()
    {
        return $this->hasMany(OwnerUnit::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function agreements()
    {
        return $this->hasMany(Agreement::class);
    }
}
