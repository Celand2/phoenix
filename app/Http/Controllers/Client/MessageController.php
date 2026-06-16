<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Services\AdminNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        return view('client.messages.index', ['messages' => Message::where('user_id', Auth::id())->latest()->paginate(20)]);
    }

    public function store(Request $request, AdminNotificationService $adminNotifications)
    {
        $message = Message::create($request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]) + ['user_id' => Auth::id(), 'from' => 'user', 'is_read' => false]);

        $user = Auth::user();
        $adminNotifications->notifyAdmins(
            'Nouveau Message de Support',
            "L'utilisateur {$user->name} a envoye un nouveau message : {$message->subject}",
            'new_message'
        );

        return back()->with('status', 'Message envoye.');
    }
}
