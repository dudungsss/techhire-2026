<?php

namespace App\Livewire\Recruiter;

use App\Models\InterviewInvitation;
use App\Models\JobApplication;
use App\Notifications\ApplicationStatusChanged;
use App\Notifications\InterviewInvitationSent;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ApplicationList extends Component
{
    public ?int $selectedJobId = null;

    public ?int $selectedApplicationId = null;

    public bool $showInviteForm = false;

    public string $invitationMessage = '';

    public string $contactInfo = '';

    public ?string $meetingLink = null;

    public ?string $location = null;

    protected $queryString = ['selectedJobId'];

    public function mount(): void
    {
        $this->selectedJobId = request()->query('selectedJobId', $this->selectedJobId);
    }

    public function selectApplication(int $applicationId): void
    {
        $this->selectedApplicationId = $applicationId;
    }

    public function closeDetail(): void
    {
        $this->selectedApplicationId = null;
    }

    public function updateStatus(int $applicationId, string $status): void
    {
        $application = $this->getRecruiterApplication($applicationId);

        $oldStatus = $application->status;
        $application->update(['status' => $status]);

        $application->load('job.company', 'user');
        $application->user->notify(new ApplicationStatusChanged(
            $application,
            $oldStatus,
            $status,
        ));

        $this->selectedApplicationId = null;

        session()->flash('success', 'Status lamaran berhasil diperbarui.');
    }

    public function toggleInviteForm(): void
    {
        $this->showInviteForm = !$this->showInviteForm;

        if ($this->showInviteForm) {
            $this->reset(['invitationMessage', 'contactInfo', 'meetingLink', 'location']);
        }
    }

    public function sendInvitation(): void
    {
        $this->validate([
            'invitationMessage' => 'required|string|max:1000',
            'contactInfo' => 'required|string|max:255',
            'meetingLink' => 'nullable|url|max:500',
            'location' => 'nullable|string|max:500',
        ]);

        $application = $this->getRecruiterApplication($this->selectedApplicationId);

        $invitation = InterviewInvitation::create([
            'job_application_id' => $application->id,
            'recruiter_id' => Auth::id(),
            'message' => $this->invitationMessage,
            'contact_info' => $this->contactInfo,
            'meeting_link' => $this->meetingLink,
            'location' => $this->location,
        ]);

        $application->load('job.company', 'user');

        $application->user->notify(new InterviewInvitationSent($invitation));

        $this->showInviteForm = false;
        $this->reset(['invitationMessage', 'contactInfo', 'meetingLink', 'location']);

        session()->flash('success', 'Undangan interview berhasil dikirim.');
    }

    private function getRecruiterApplication(int $applicationId): JobApplication
    {
        return JobApplication::query()
            ->whereHas('job.company', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->findOrFail($applicationId);
    }

    public function getSelectedApplicationProperty(): ?JobApplication
    {
        if (! $this->selectedApplicationId) {
            return null;
        }

        return JobApplication::query()
            ->with(['job.company', 'job.category', 'user.skills', 'job.skills'])
            ->whereHas('job.company', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->find($this->selectedApplicationId);
    }

    public function render()
    {
        $query = JobApplication::query()
            ->with(['job.company', 'job.category', 'user.skills'])
            ->whereHas('job.company', function ($query) {
                $query->where('user_id', Auth::id());
            });

        if ($this->selectedJobId) {
            $query->where('job_id', $this->selectedJobId);
        }

        $applications = $query
            ->orderBy('match_score', 'desc')
            ->latest()
            ->paginate(10);

        $jobs = Auth::user()
            ->company
            ?->jobs()
            ->withCount('applications')
            ->orderBy('title')
            ->get();

        return view('livewire.recruiter.application-list', [
            'applications' => $applications,
            'jobs' => $jobs,
        ]);
    }
}
