<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasProjectScope;

class Decision extends Model
{
    use HasFactory, HasProjectScope;

    protected $fillable = [
        'project_id','title','description','created_by_user_id','status'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function signatures()
    {
        return $this->hasMany(Signature::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }
}
