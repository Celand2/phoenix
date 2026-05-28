@extends('layouts.client')

@section('title', 'Messages')

@section('content')
<form method="POST" action="{{ route('client.messages.store') }}" class="mb-6 grid gap-3 rounded-lg border border-ash-600 bg-ash-800 p-4">@csrf
<input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="subject" placeholder="Sujet">
<textarea class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="body" placeholder="Message"></textarea>
<button class="rounded-lg bg-crimson-400 px-4 py-2 font-semibold text-white">Envoyer</button></form>
<div class="grid gap-3">@foreach($messages as $message)<article class="rounded-lg border border-ash-600 bg-ash-800 p-4"><div class="flex justify-between gap-3"><h2 class="font-semibold">{{ $message->subject }}</h2><span class="text-sm text-ash-200">{{ $message->from }}</span></div><p class="mt-2 whitespace-pre-line text-ash-100">{{ $message->body }}</p></article>@endforeach</div>{{ $messages->links() }}
@endsection
