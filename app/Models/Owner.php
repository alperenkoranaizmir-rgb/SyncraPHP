<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasProjectScope;

class Owner extends Model
{
    use HasFactory, HasProjectScope;
    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'owner_unit')->withPivot('share_percent','owner_type');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function signatures()
    {
        return $this->hasMany(Signature::class);
    }
}
