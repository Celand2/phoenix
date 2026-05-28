<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        return view('admin.notifications.index', ['notifications' => Notification::with('user')->latest()->paginate(20), 'users' => User::orderBy('name')->get()]);
    }

    public function send(Request $request, NotificationService $notificationService)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'type' => ['required', 'string', 'max:255'],
        ]);

        $notificationService->send(User::findOrFail($data['user_id']), $data['title'], $data['body'], $data['type']);

        return back()->with('status', 'Notification envoyee.');
    }
}
