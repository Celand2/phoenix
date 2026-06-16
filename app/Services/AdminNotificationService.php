<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Notification;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;

class AdminNotificationService
{
    public function notifyAdmins(string $title, string $body, string $type): void
    {
        $admins = Admin::all();

        foreach ($admins as $admin) {
            // App notification
            $notification = Notification::create([
                'admin_id' => $admin->id,
                'title' => $title,
                'body' => $body,
                'type' => $type,
                'is_read' => false,
                'is_emailed' => false,
            ]);

            // Email notification
            $this->sendEmail($admin, $notification);
        }
    }

    private function sendEmail(Admin $admin, Notification $notification): void
    {
        try {
            Mail::to($admin->email)->send(new NotificationMail($notification));
            $notification->update(['is_emailed' => true]);
        } catch (\Exception $e) {
            // Email failed but notification is saved
        }
    }
}
