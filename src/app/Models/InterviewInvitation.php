<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewInvitation extends Model
{
    protected $fillable = [
        'job_application_id',
        'recruiter_id',
        'message',
        'contact_info',
        'meeting_link',
        'location',
        'status',
        'responded_at',
    ];

    protected function casts(): array
    {
        return [
            'responded_at' => 'datetime',
        ];
    }

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class);
    }

    public function recruiter()
    {
        return $this->belongsTo(User::class, 'recruiter_id');
    }
}
