<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Sponsor extends Model
{
    use HasFactory;
    protected $fillable = [
        'sponsor_name', 'project_name', 'project_manager', 
        'contract_holder_country', 'contract_value',
         'task_done', 'task_remain', 'status'
    ];
}
