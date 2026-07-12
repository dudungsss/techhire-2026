<?php

namespace App\Mail;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public JobApplication $application,
        public string $oldStatus,
        public string $newStatus,
    ) {}

    public function build(): self
    {
        return $this
            ->subject('Status Lamaran: ' . $this->application->job->title)
            ->view('emails.application-status-changed');
    }
}
