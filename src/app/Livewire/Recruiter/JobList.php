<?php

namespace App\Livewire\Recruiter;

use App\Models\Job;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class JobList extends Component
{

    public function togglePublish(int $jobId): void
    {
        $job = $this->getRecruiterJob($jobId);
        
        $job->update([
            'is_published' => ! $job->is_published,
        ]);

        session()->flash(
            'success',
            $job->fresh()->is_published
                ? 'Lowongan berhasil dipublish.'
                : 'Lowongan berhasil dijadikan draft.'
        );
    }

    public function delete(int $jobId): void
    {
        $job = $this->getRecruiterJob($jobId);

        $job->delete();

        session()->flash('success', 'Lowongan berhasil dihapus.');
    }

    private function getRecruiterJob(int $jobId): Job
    {
        return Job::query()
            ->whereHas('company', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->findOrFail($jobId);
    }

    public function render()
    {
        $jobs = Job::query()
            ->with(['company', 'category', 'skills'])
            ->withCount('applications')
            ->whereHas('company', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->paginate(10);

        return view('livewire.recruiter.joblist', [
            'jobs' => $jobs,
        ]);
    }

}