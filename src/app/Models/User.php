<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'avatar_url',
        'name',
        'email',
        'password',
        'recruiter_status',
        'phone',
        'summary',
        'cv_path',
        'github_url',
        'linkedin_url',
        'portfolio_url',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getFilamentAvatarUrl(): ?string
    {
        if ($this->avatar_url) {
            return asset('storage/' . $this->avatar_url);
        } else {
            $hash = md5(strtolower(trim($this->email)));

            return 'https://www.gravatar.com/avatar/' . $hash . '?d=mp&r=g&s=250';
        }
    }

    public function canAccessPanel(Panel $panel): bool
    {
    return $this->is_active
        && $this->hasAnyRole(['super_admin', 'admin']);
    }

    public function isAdmin(): bool
    {
    return $this->hasAnyRole(['super_admin', 'admin']);
    }

    public function isRecruiter(): bool
    {
        return $this->hasRole('recruiter');
    }

    public function isRecruiterVerified(): bool
    {
        return $this->isRecruiter() && $this->recruiter_status === 'verified';
    }

    public function isPelamar(): bool
    {
        return $this->hasRole('pelamar');
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function bookmarkedJobs()
    {
        return $this->belongsToMany(Job::class, 'user_bookmarks')->withTimestamps();
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_skill')->withTimestamps();
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function recruiterInvitations()
    {
        return $this->hasMany(\App\Models\InterviewInvitation::class, 'recruiter_id');
    }

    public function profileCompletenessPercentage(): int
    {
        $score = 0;

        if (!empty($this->name)) $score += 10;
        if (!empty($this->phone)) $score += 10;
        if (!empty($this->summary)) $score += 20;
        if (!empty($this->cv_path)) $score += 25;
        if ($this->skills()->count() > 0) $score += 20;
        if (!empty($this->github_url)) $score += 5;
        if (!empty($this->linkedin_url)) $score += 5;
        if (!empty($this->portfolio_url)) $score += 5;

        return min($score, 100);
    }
}
