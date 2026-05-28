<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        return view('client.notifications.index', ['notifications' => Notification::where('user_id', Auth::id())->latest()->paginate(20)]);
    }

    public function markRead(Notification $notification)
    {
        abort_unless($notification->user_id === Auth::id(), 403);
        $notification->update(['is_read' => true]);

        return back()->with('status', 'Notification lue.');
    }
}
