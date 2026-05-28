@extends('layouts.client')

@section('title', 'Notifications')

@section('content')
<div class="grid gap-3">@foreach($notifications as $notification)<article class="rounded-lg border border-ash-600 bg-ash-800 p-4"><div class="flex flex-wrap items-center justify-between gap-3"><div><h2 class="font-semibold">{{ $notification->title }}</h2><p class="text-sm text-ash-200">{{ $notification->type }}</p></div>@if(! $notification->is_read)<form method="POST" action="{{ route('client.notifications.read', $notification) }}">@csrf<button class="rounded-lg bg-gold-400 px-3 py-1 text-ash-900">Lu</button></form>@endif</div><p class="mt-2 whitespace-pre-line text-ash-100">{{ $notification->body }}</p></article>@endforeach</div>{{ $notifications->links() }}
@endsection
