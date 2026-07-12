<?php

namespace App\Livewire\Applicant;

use App\Models\Job;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class JobRecommendations extends Component
{
    public function render()
    {
        $user = Auth::user();
        $recommendations = collect();

        if ($user && $user->hasRole('pelamar')) {
            $userSkillIds = $user->skills()->pluck('skills.id');

            if ($userSkillIds->isNotEmpty()) {
                $jobs = Job::query()
                    ->with(['company', 'category', 'skills'])
                    ->published()
                    ->latest()
                    ->limit(50)
                    ->get();

                $recommendations = $jobs
                    ->map(function ($job) use ($userSkillIds) {
                        $jobSkillIds = $job->skills->pluck('id');
                        $job->match_score = $jobSkillIds->isNotEmpty()
                            ? (int) round(($userSkillIds->intersect($jobSkillIds)->count() / $jobSkillIds->count()) * 100)
                            : 0;
                        return $job;
                    })
                    ->filter(fn ($job) => $job->match_score > 0)
                    ->sortByDesc('match_score')
                    ->take(5)
                    ->values();
            }
        }

        return view('livewire.applicant.job-recommendations', [
            'recommendations' => $recommendations,
        ]);
    }
}
