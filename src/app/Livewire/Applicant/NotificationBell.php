<?php

namespace App\Livewire\Applicant;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationBell extends Component
{
    public bool $showDropdown = false;

    public function toggleDropdown(): void
    {
        $this->showDropdown = !$this->showDropdown;
    }

    public function markAsRead(string $notificationId): void
    {
        $notification = Auth::user()->notifications()->where('id', $notificationId)->first();

        if ($notification) {
            $notification->markAsRead();
        }
    }

    public function markAllAsRead(): void
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->showDropdown = false;
    }

    public function render()
    {
        try {
            $unreadCount = Auth::user()->unreadNotifications()->count();
            $notifications = Auth::user()->notifications()->latest()->take(5)->get();
        } catch (\Exception $e) {
            $unreadCount = 0;
            $notifications = collect();
        }

        return view('livewire.applicant.notification-bell', [
            'unreadCount' => $unreadCount,
            'notifications' => $notifications,
        ]);
    }
}
