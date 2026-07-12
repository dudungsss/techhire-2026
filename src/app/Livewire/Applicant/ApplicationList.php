<?php

namespace App\Livewire\Applicant;

use App\Models\JobApplication;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ApplicationList extends Component
{
    public function render()
    {
        $applications = JobApplication::query()
            ->with(['job.company', 'job.category'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('livewire.applicant.application-list', [
            'applications' => $applications,
        ]);
    }
}