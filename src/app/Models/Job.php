<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'company_id',
        'category_id',
        'title',
        'slug',
        'description',
        'requirements',
        'responsibilities',
        'salary_min',
        'salary_max',
        'location',
        'employment_type',
        'experience_level',
        'deadline_at',
        'is_published',
    ];

    protected $casts = [
        'deadline_at' => 'date',
        'is_published' => 'boolean',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_skill')->withTimestamps();
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function bookmarkedBy()
    {
        return $this->belongsToMany(User::class, 'user_bookmarks')->withTimestamps();
    }
}
