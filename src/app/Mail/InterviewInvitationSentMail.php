<?php

namespace App\Mail;

use App\Models\InterviewInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InterviewInvitationSentMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public InterviewInvitation $invitation,
    ) {}

    public function build(): self
    {
        return $this
            ->subject('Undangan Interview: ' . $this->invitation->jobApplication->job->title)
            ->view('emails.interview-invitation-sent');
    }
}
