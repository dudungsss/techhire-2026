<?php

namespace App\Notifications;

use App\Mail\InterviewInvitationSentMail;
use App\Models\InterviewInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class InterviewInvitationSent extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public InterviewInvitation $invitation,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): InterviewInvitationSentMail
    {
        return new InterviewInvitationSentMail($this->invitation);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'invitation_id' => $this->invitation->id,
            'job_title' => $this->invitation->jobApplication->job->title,
            'company_name' => $this->invitation->jobApplication->job->company->name,
            'contact_info' => $this->invitation->contact_info,
            'meeting_link' => $this->invitation->meeting_link,
            'location' => $this->invitation->location,
        ];
    }
}
