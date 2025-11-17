<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','location_json','type','status','total_units','total_m2','construction_area','start_date','est_end_date','est_budget','emsal_ratio','photos','manager_id'
    ];

    protected $casts = [
        'location_json' => 'array',
        'photos' => 'array',
        'start_date' => 'date',
        'est_end_date' => 'date',
        'total_m2' => 'decimal:2',
        'construction_area' => 'decimal:2',
        'est_budget' => 'decimal:2',
    ];

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function owners()
    {
        return $this->hasMany(Owner::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function decisions()
    {
        return $this->hasMany(Decision::class);
    }

    public function agreements()
    {
        return $this->hasMany(Agreement::class);
    }

    public function changeLogs()
    {
        return $this->hasMany(ChangeLog::class);
    }

    public function projectUsers()
    {
        return $this->hasMany(ProjectUser::class);
    }
}
