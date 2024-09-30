<?php
namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
class Project extends Model
{
    use HasFactory;
    public $appends = ['months'];
    protected $fillable = [
        'sponsor_name',
        'project_name',
        'contract_holder_country',
        'project_manager',
        'currency',
        'contract_value',
        'contract_signed',
        'billing_type',
        'activity_start_date',
        'billing_start_date',
        'clinical_duration',
        'study_duration',
        'patients',
        'sites',
        'status',
        'phase',
        'therapeutic_area',
        'sponsor_country',
        'created_by',
    ];
    public function getMonthsAttribute()
    {
        $start_date = Carbon::parse($this->activity_start_date);
        $duration = ceil($this->study_duration);

        $months = [];
        for ($i = 0; $i < $duration; $i++) {
            $months[] = $start_date->copy()->addMonths($i)->startOfMonth();
        }
        return $months;
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function groups()
    {
        return $this->hasMany(Group::class);
    }
    public function tasks()
{
    return $this->hasMany(Task::class);
}

    public function users()
    {
        return $this->morphedByMany(User::class, 'assignable', 'project_assignments');
    }
    public function teams()
    {
        return $this->morphedByMany(Team::class, 'assignable', 'project_assignments');
    }
    public function locks()
    {
        return $this->hasMany(Lock::class);
    }
    protected static function booted()
    {
        static::created(function ($project) {
            $months = $project->months;
            $locks = [];
            foreach ($months as $month) {
                $locks[] = [
                    'project_id' => $project->id,
                    'date' => $month,
                    'is_locked' => false,
                ];
            }
            Lock::insert($locks);
        });
        static::deleting(function ($project) {
            $project->groups()->delete();
            $project->locks()->delete();
        });
    }
}
