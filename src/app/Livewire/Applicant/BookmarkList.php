<?php

namespace App\Livewire\Applicant;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class BookmarkList extends Component
{
    public function removeBookmark(int $jobId): void
    {
        $user = Auth::user();

        if ($user && $user->hasRole('pelamar')) {
            $user->bookmarkedJobs()->detach($jobId);
        }
    }

    public function render()
    {
        $user = Auth::user();

        $jobs = $user?->hasRole('pelamar')
            ? $user->bookmarkedJobs()
                ->with(['company', 'category', 'skills'])
                ->latest()
                ->paginate(10)
            : collect();

        return view('livewire.applicant.bookmark-list', [
            'jobs' => $jobs,
        ]);
    }
}
