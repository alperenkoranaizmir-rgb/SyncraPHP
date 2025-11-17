<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasProjectScope;

class ChangeLog extends Model
{
    use HasFactory, HasProjectScope;

    protected $table = 'change_logs';

    protected $fillable = [
        'user_id','project_id','model_type','model_id','action','changes_json'
    ];

    protected $casts = [
        'changes_json' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
