<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

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

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
