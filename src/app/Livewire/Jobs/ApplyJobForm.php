<?php

namespace App\Livewire\Jobs;

use App\Models\Job;
use App\Models\JobApplication;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class ApplyJobForm extends Component
{
    use WithFileUploads;

    public Job $job;

    public $cv;

    public ?string $cover_letter = null;

    public ?string $experience_summary = null;

    public ?string $portfolio_url = null;

    public ?string $expected_salary = null;

    public bool $alreadyApplied = false;

    public function mount(Job $job): void
    {
        abort_unless(Auth::check(), 403);
        abort_unless(Auth::user()->hasRole('pelamar'), 403);

        $this->job = $job;

        $this->alreadyApplied = JobApplication::query()
            ->where('job_id', $this->job->id)
            ->where('user_id', Auth::id())
            ->exists();

        $this->portfolio_url = Auth::user()->portfolio_url;
    }

    public function apply(): void
    {
        abort_unless(Auth::check(), 403);
        abort_unless(Auth::user()->hasRole('pelamar'), 403);


        if (! $this->job->is_published) {
            session()->flash('error', 'Lowongan ini belum dipublish.');
            return;
        }

        if ($this->job->deadline_at && $this->job->deadline_at->isPast()) {
            session()->flash('error', 'Deadline lowongan sudah lewat.');
            return;
        }

        $exists = JobApplication::query()
            ->where('job_id', $this->job->id)
            ->where('user_id', Auth::id())
            ->exists();

        if ($exists) {
            $this->alreadyApplied = true;
            session()->flash('error', 'Kamu sudah pernah apply lowongan ini.');
            return;
        }

        $validated = $this->validate([
            'cv' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:2048'],
            'cover_letter' => ['nullable', 'string', 'max:5000'],
            'experience_summary' => ['nullable', 'string', 'max:5000'],
            'portfolio_url' => ['nullable', 'url', 'max:255'],
            'expected_salary' => ['nullable', 'numeric', 'min:0'],
        ]);

        $cvPath = null;

        if ($this->cv) {
            $cvPath = $this->cv->store('applications/cv', 'public');
        }

        $matchScore = $this->calculateMatchScore();

        JobApplication::create([
            'job_id' => $this->job->id,
            'user_id' => Auth::id(),
            'cv_path' => $cvPath,
            'cover_letter' => $validated['cover_letter'] ?? null,
            'experience_summary' => $validated['experience_summary'] ?? null,
            'portfolio_url' => $validated['portfolio_url'] ?? null,
            'expected_salary' => $validated['expected_salary'] ?? null,
            'match_score' => $matchScore,
            'status' => 'pending',
        ]);

        $this->alreadyApplied = true;

        $this->reset([
            'cv',
            'cover_letter',
            'experience_summary',
            'portfolio_url',
            'expected_salary',
        ]);

        session()->flash('success', 'Lamaran berhasil dikirim.');
    }

    private function calculateMatchScore(): int
    {
        $jobSkillIds = $this->job->skills()->pluck('skills.id')->toArray();

        if (empty($jobSkillIds)) {
            return 0;
        }

        $userSkillIds = Auth::user()->skills()->pluck('skills.id')->toArray();

        $matching = array_intersect($jobSkillIds, $userSkillIds);

        return (int) round((count($matching) / count($jobSkillIds)) * 100);
    }

    public function render()
    {
        return view('livewire.jobs.apply-job-form');
    }
}