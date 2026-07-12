<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'type',
    ];

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_skill')->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_skill')->withTimestamps();
    }
}