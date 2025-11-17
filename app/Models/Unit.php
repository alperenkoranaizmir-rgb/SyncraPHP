<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasProjectScope;

class Unit extends Model
{
    use HasFactory, HasProjectScope;

    protected $fillable = [
        'project_id','block','ada','parsel','unit_no','unit_type','floor','interior_door_no','exterior_door_no','area_m2','arsa_payi_num','arsa_payi_den','tapu_cilt_no','tapu_sayfa_no','edinme_sebebi','edinme_tarihi','tapu_haciz','tapu_raw_json','usage_status','description'
    ];

    protected $casts = [
        'tapu_raw_json' => 'array',
        'area_m2' => 'decimal:2',
        'tapu_haciz' => 'boolean',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function owners()
    {
        return $this->belongsToMany(Owner::class, 'owner_unit')->withPivot('share_percent','owner_type')->withTimestamps();
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
