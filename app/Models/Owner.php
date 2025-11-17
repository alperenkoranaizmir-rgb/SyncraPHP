<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasProjectScope;

class Owner extends Model
{
    use HasFactory, HasProjectScope;

    protected $fillable = [
        'project_id','first_name','last_name','tc_no','father_name','birth_date','birth_place','gender','email','phone_primary','phone_secondary','address','emergency_contact_name','emergency_contact_phone','emergency_contact_address','education','employment_status','marital_status','photo_path','disability_flag','disability_type','disability_report_path'
    ];

    protected $casts = [
        'disability_flag' => 'boolean',
        'birth_date' => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'owner_unit')->withPivot('share_percent','owner_type')->withTimestamps();
    }

    public function ownerUnits()
    {
        return $this->hasMany(OwnerUnit::class);
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
