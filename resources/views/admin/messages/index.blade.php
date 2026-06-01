@extends('layouts.admin')
<form method="POST" action="{{ route('admin.messages.store') }}" class="grid max-w-2xl gap-3">
    @csrf
    <select class="rounded-lg border border-ash-200 bg-ash-50 px-3 py-2 text-ash-900 transition-colors hover:bg-ash-100 focus:border-crimson-400 focus:outline-none focus:ring-1 focus:ring-crimson-400" name="user_id">@foreach($users as $user)<option value="{{ $user->id }}">{{ $user->name }}</option>@endforeach</select>
    <input class="rounded-lg border border-ash-200 bg-ash-50 px-3 py-2 text-ash-900 transition-colors hover:bg-ash-100 focus:border-crimson-400 focus:outline-none focus:ring-1 focus:ring-crimson-400" name="subject" placeholder="Sujet">
    <textarea class="rounded-lg border border-ash-200 bg-ash-50 px-3 py-2 text-ash-900 transition-colors hover:bg-ash-100 focus:border-crimson-400 focus:outline-none focus:ring-1 focus:ring-crimson-400" name="body" placeholder="Message"></textarea>
    <button class="rounded-lg bg-crimson-400 px-4 py-2 font-semibold text-white">Envoyer</button>
</form>

<div class="mt-8">
    <div class="overflow-x-auto rounded-lg border border-ash-200 bg-white shadow-sm"><table class="w-full text-left text-sm"><thead class="bg-ash-50 text-ash-600 border-b border-ash-200"><tr><th class="p-3">Client</th><th>Sujet</th><th>From</th><th></th></tr></thead><tbody>@foreach($messages as $message)<tr class="border-t border-ash-100 hover:bg-ash-50 transition-colors"><td class="p-3">{{ $message->user?->name }}</td><td>{{ $message->subject }}</td><td>{{ $message->from }}</td><td><a class="text-crimson-600 font-medium" href="{{ route('admin.messages.show', $message) }}">Voir</a></td></tr>@endforeach</tbody></table></div>{{ $messages->links() }}
</div>
