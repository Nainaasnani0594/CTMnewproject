<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function assignedProjects()
    {
        return $this->morphedByMany(Project::class, 'assignable', 'assignables', 'assigned_id')
            ->where('assigned_type', Team::class);
    }

    public function assignedGroups()
    {
        return $this->morphedByMany(Group::class, 'assignable', 'assignables', 'assigned_id')
            ->where('assigned_type', Team::class);
    }
}
