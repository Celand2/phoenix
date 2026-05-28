<?php

namespace App\Services;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;

class NotificationService
{
    public function send(User $user, string $title, string $body, string $type): void
    {
        $notification = Notification::create([
            'user_id' => $user->id,
            'title' => $title,
            'body' => $body,
            'type' => $type,
            'is_read' => false,
            'is_emailed' => false,
        ]);

        $this->sendEmail($user, $notification);
    }

    private function sendEmail(User $user, Notification $notification): void
    {
        try {
            Mail::to($user->email)->send(new NotificationMail($notification));
            $notification->update(['is_emailed' => true]);
        } catch (\Exception $e) {
            // Email failed but notification is saved
        }
    }
}
