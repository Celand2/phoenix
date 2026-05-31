@extends('layouts.client')

@section('title', 'Notifications')

@section('content')
<h1 class="mb-6 text-2xl font-black text-ash-900">Mes Notifications</h1>

<div class="grid gap-4">
    @forelse($notifications as $notification)
    <article class="relative overflow-hidden rounded-2xl border border-gold-100 bg-white p-6 shadow-sm transition-all hover:shadow-md {{ !$notification->is_read ? 'border-l-4 border-l-crimson-400' : '' }}">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="min-w-0 flex-1">
                <div class="flex items-center gap-2">
                    @if(!$notification->is_read)
                        <span class="size-2 shrink-0 rounded-full bg-crimson-400"></span>
                    @endif
                    <h2 class="truncate text-lg font-bold text-ash-900">{{ $notification->title }}</h2>
                </div>
                <p class="text-xs font-bold uppercase tracking-widest text-ash-400">{{ $notification->type }} • {{ $notification->created_at?->diffForHumans() }}</p>
            </div>
            
            @if(!$notification->is_read)
            <form method="POST" action="{{ route('client.notifications.read', $notification) }}">
                @csrf
                <button class="rounded-xl bg-gold-100 px-4 py-2 text-sm font-black text-gold-800 transition-colors hover:bg-gold-200">
                    Marquer comme lu
                </button>
            </form>
            @endif
        </div>
        
        <div class="mt-4 text-sm leading-relaxed text-ash-700">
            <p class="whitespace-pre-line">{{ $notification->body }}</p>
        </div>
    </article>
    @empty
    <div class="rounded-2xl border border-ash-100 bg-ash-50 p-12 text-center text-ash-400">
        Vous n'avez aucune notification.
    </div>
    @endforelse
</div>

<div class="mt-8">
    {{ $notifications->links() }}
</div>
@endsection
