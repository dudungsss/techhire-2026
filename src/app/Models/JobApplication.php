<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $fillable = [
        'job_id',
        'user_id',
        'cv_path',
        'cover_letter',
        'experience_summary',
        'portfolio_url',
        'expected_salary',
        'match_score',
        'status',
    ];

    protected $casts = [
        'expected_salary' => 'decimal:2',
        'match_score' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function interviewInvitations()
    {
        return $this->hasMany(\App\Models\InterviewInvitation::class);
    }
}
