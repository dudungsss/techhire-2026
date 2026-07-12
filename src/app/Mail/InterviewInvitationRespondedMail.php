<?php

namespace App\Mail;

use App\Models\InterviewInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InterviewInvitationRespondedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public InterviewInvitation $invitation,
        public string $response,
    ) {}

    public function build(): self
    {
        $label = $this->response === 'accepted' ? 'Diterima' : 'Ditolak';

        return $this
            ->subject("Undangan Interview {$label}: {$this->invitation->jobApplication->job->title}")
            ->view('emails.interview-invitation-responded');
    }
}
