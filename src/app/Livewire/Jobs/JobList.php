<?php

namespace App\Livewire\Jobs;

use App\Models\Category;
use App\Models\Job;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class JobList extends Component
{
    public string $search = '';

    public ?string $category = null;

    public function mount(): void
    {
        $this->search = request()->query('search', '');
        $this->category = request()->query('category');
    }


    public ?string $location = null;

    public array $employmentType = [];

    public array $experienceLevel = [];

    public function toggleBookmark(int $jobId): void
    {
        $user = Auth::user();
        if (! $user || ! $user->hasRole('pelamar')) {
            return;
        }

        $job = Job::published()->findOrFail($jobId);

        if ($user->bookmarkedJobs()->where('job_id', $jobId)->exists()) {
            $user->bookmarkedJobs()->detach($jobId);
        } else {
            $user->bookmarkedJobs()->attach($jobId);
        }
    }

    public function resetFilters(): void
    {
        $this->reset([
            'search',
            'category',
            'location',
            'employmentType',
            'experienceLevel',
        ]);
    }

    public function render()
    {
        $user = Auth::user();
        $userSkillIds = $user?->hasRole('pelamar') ? $user->skills()->pluck('skills.id') : collect();

        $jobs = Job::query()
            ->with(['company', 'category', 'skills'])
            ->published()
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query
                        ->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        ->orWhereHas('company', function ($companyQuery) {
                            $companyQuery->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->category, function ($query) {
                $query->where('category_id', $this->category);
            })
            ->when($this->location, function ($query) {
                $query->where('location', 'like', '%' . $this->location . '%');
            })
            ->when(! empty($this->employmentType), function ($query) {
                $query->whereIn('employment_type', $this->employmentType);
            })
            ->when(! empty($this->experienceLevel), function ($query) {
                $query->whereIn('experience_level', $this->experienceLevel);
            })
            ->latest()
            ->paginate(10)
            ->through(function ($job) use ($userSkillIds) {
                if ($userSkillIds->isNotEmpty()) {
                    $jobSkillIds = $job->skills->pluck('id');
                    $job->match_score = $jobSkillIds->isNotEmpty()
                        ? (int) round(($userSkillIds->intersect($jobSkillIds)->count() / $jobSkillIds->count()) * 100)
                        : null;
                }
                return $job;
            });

        $bookmarkedIds = $user?->hasRole('pelamar')
            ? $user->bookmarkedJobs()->pluck('job_id')->toArray()
            : [];

        return view('livewire.jobs.joblist', [
            'jobs' => $jobs,
            'categories' => Category::query()
                ->orderBy('name')
                ->get(),
            'showMatchScore' => $userSkillIds->isNotEmpty(),
            'bookmarkedIds' => $bookmarkedIds,
        ]);
    }
}
