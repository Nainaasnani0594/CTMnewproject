<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'group_id',
        'unit',
        'quantity',
        'price',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    protected static function booted()
    {
        static::created(function ($task) {
            $project = $task->group->project;
            $start_date = Carbon::parse($project->activity_start_date);
            $duration = ceil($project->study_duration);

            $activities = [];
            for ($i = 0; $i < $duration; $i++) {
                $activities[] = [
                    'task_id' => $task->id,
                    'date' => $start_date->copy()->addMonths($i)->startOfMonth(),
                    'value' => 0,
                ];
            }

            Activity::insert($activities);
        });
    }
}
