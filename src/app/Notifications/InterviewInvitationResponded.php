<?php

namespace App\Notifications;

use App\Mail\InterviewInvitationRespondedMail;
use App\Models\InterviewInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class InterviewInvitationResponded extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public InterviewInvitation $invitation,
        public string $response,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): InterviewInvitationRespondedMail
    {
        return new InterviewInvitationRespondedMail($this->invitation, $this->response);
    }

    public function toArray(object $notifiable): array
    {
        return [
            'invitation_id' => $this->invitation->id,
            'job_title' => $this->invitation->jobApplication->job->title,
            'applicant_name' => $this->invitation->jobApplication->user->name,
            'response' => $this->response,
        ];
    }
}
