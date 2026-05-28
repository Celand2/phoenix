<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return view('admin.messages.index', ['messages' => Message::with('user')->latest()->paginate(20), 'users' => User::orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        Message::create($request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]) + ['from' => 'admin', 'is_read' => false]);

        return back()->with('status', 'Message envoye.');
    }

    public function show(Message $message)
    {
        return view('admin.messages.show', compact('message'));
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return back()->with('status', 'Message supprime.');
    }
}
