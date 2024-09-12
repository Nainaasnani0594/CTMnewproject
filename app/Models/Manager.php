<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Manager extends Authenticatable
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name',  'email', 'password'];
    protected $hidden = ['password'];

    public function users()
    {
        // return $this->belongsToMany(User::class)->withTimestamps();
        return $this->hasMany(User::class);

    }
    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

}
