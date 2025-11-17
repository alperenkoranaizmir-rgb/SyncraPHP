<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasProjectScope;

class Agreement extends Model
{
    use HasFactory, HasProjectScope;

    protected $fillable = [
        'project_id','unit_id','status','meeting_date','met_person_name','met_by_user_id','notes'
    ];

    protected $casts = [
        'meeting_date' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function metBy()
    {
        return $this->belongsTo(User::class, 'met_by_user_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
