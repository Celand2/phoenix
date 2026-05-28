@extends('layouts.admin')

@section('title', 'Messages')

@section('content')
<form method="POST" action="{{ route('admin.messages.store') }}" class="mb-6 grid gap-3 rounded-lg border border-ash-600 bg-ash-800 p-4">@csrf
<select class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="user_id">@foreach($users as $user)<option value="{{ $user->id }}">{{ $user->name }}</option>@endforeach</select>
<input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="subject" placeholder="Sujet">
<textarea class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="body" placeholder="Message"></textarea>
<button class="rounded-lg bg-crimson-400 px-4 py-2 font-semibold text-white">Envoyer</button></form>
<div class="overflow-x-auto rounded-lg border border-ash-600 bg-ash-800"><table class="w-full text-left text-sm"><thead class="bg-ash-900 text-ash-200"><tr><th class="p-3">Client</th><th>Sujet</th><th>From</th><th></th></tr></thead><tbody>@foreach($messages as $message)<tr class="border-t border-ash-600"><td class="p-3">{{ $message->user?->name }}</td><td>{{ $message->subject }}</td><td>{{ $message->from }}</td><td><a class="text-gold-400" href="{{ route('admin.messages.show', $message) }}">Voir</a></td></tr>@endforeach</tbody></table></div>{{ $messages->links() }}
@endsection
