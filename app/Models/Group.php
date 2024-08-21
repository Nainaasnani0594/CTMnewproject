<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'project_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function assignedUsers()
    {
        return $this->morphToMany(User::class, 'assignable', 'assignables', 'assignable_id', 'assigned_id')
            ->where('assigned_type', User::class);
    }

    public function assignedTeams()
    {
        return $this->morphToMany(Team::class, 'assignable', 'assignables', 'assignable_id', 'assigned_id')
            ->where('assigned_type', Team::class);
    }

    protected static function booted()
    {
        static::deleting(function ($group) {
            $group->tasks()->delete();
        });
    }
}
