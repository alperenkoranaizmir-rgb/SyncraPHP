<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasProjectScope;

class Document extends Model
{
    use HasFactory, HasProjectScope;

    protected $fillable = [
        'project_id','unit_id','owner_id','agreement_id','doc_type','file_path','uploaded_by_user_id','uploaded_at'
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function agreement()
    {
        return $this->belongsTo(Agreement::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by_user_id');
    }
}
