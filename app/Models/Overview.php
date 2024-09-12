<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overview extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_name', 'contract_value', 'work_done', 'country', 'phase', 'therapeutic_area', 'status'
    ];

}
