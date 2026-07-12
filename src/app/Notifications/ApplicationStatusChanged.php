<?php

namespace App\Notifications;

use App\Mail\ApplicationStatusChangedMail;
use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApplicationStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public JobApplication $application,
        public string $oldStatus,
        public string $newStatus,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): ApplicationStatusChangedMail
    {
        return new ApplicationStatusChangedMail(
            $this->application,
            $this->oldStatus,
            $this->newStatus,
        );
    }

    public function toArray(object $notifiable): array
    {
        return [
            'application_id' => $this->application->id,
            'job_title' => $this->application->job->title,
            'company_name' => $this->application->job->company->name,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
        ];
    }
}
