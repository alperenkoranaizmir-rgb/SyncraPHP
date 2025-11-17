<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasProjectScope;

class Project extends Model
{
    use HasFactory;
    // Projects are not scoped by project_id themselves
    protected $guarded = [];

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function owners()
    {
        return $this->hasMany(Owner::class);
    }

    public function agreements()
    {
        return $this->hasMany(Agreement::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function decisions()
    {
        return $this->hasMany(Decision::class);
    }

    public function projectUsers()
    {
        return $this->hasMany(ProjectUser::class);
    }
}
