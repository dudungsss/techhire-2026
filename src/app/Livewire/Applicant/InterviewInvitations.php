<?php

namespace App\Livewire\Applicant;

use App\Models\InterviewInvitation;
use App\Notifications\InterviewInvitationResponded;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class InterviewInvitations extends Component
{
    public function accept(int $invitationId): void
    {
        $invitation = $this->getInvitation($invitationId);
        $invitation->update([
            'status' => 'accepted',
            'responded_at' => now(),
        ]);

        $recruiter = $invitation->recruiter;
        $recruiter->notify(new InterviewInvitationResponded($invitation, 'accepted'));

        session()->flash('success', 'Undangan interview diterima. Rekruter akan menghubungi kamu.');
    }

    public function decline(int $invitationId): void
    {
        $invitation = $this->getInvitation($invitationId);
        $invitation->update([
            'status' => 'declined',
            'responded_at' => now(),
        ]);

        $recruiter = $invitation->recruiter;
        $recruiter->notify(new InterviewInvitationResponded($invitation, 'declined'));

        session()->flash('success', 'Undangan interview ditolak.');
    }

    private function getInvitation(int $invitationId): InterviewInvitation
    {
        return InterviewInvitation::query()
            ->whereHas('jobApplication', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->findOrFail($invitationId);
    }

    public function render()
    {
        $invitations = InterviewInvitation::query()
            ->with(['jobApplication.job.company', 'recruiter'])
            ->whereHas('jobApplication', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->get();

        return view('livewire.applicant.interview-invitations', [
            'invitations' => $invitations,
        ]);
    }
}
