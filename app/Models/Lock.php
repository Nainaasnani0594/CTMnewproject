<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lock extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'project_id',
        'is_locked',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    protected $casts = [
        'is_locked' => 'boolean',
    ];
}
