@extends('layouts.client')

@section('title', 'Mes trades')

@section('content')
<div class="grid gap-4">
@foreach($userTrades as $userTrade)
@php($nextClaimAt = $userTrade->last_claimed_at?->copy()->addHours(24))
<article class="rounded-lg border border-ash-600 bg-ash-800 p-5">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div><h2 class="text-lg font-bold">{{ $userTrade->trade?->name }}</h2><p class="text-sm text-ash-200">{{ $userTrade->category?->name }} - {{ $userTrade->status }}</p></div>
        <p class="text-gold-400 font-bold">{{ $userTrade->daily_gain }}/jour</p>
    </div>
    @if($userTrade->status === 'active')
    <button data-claim-url="{{ route('client.my-trades.claim', $userTrade) }}" data-next-claim-at="{{ $nextClaimAt?->toIso8601String() }}" class="claim-button mt-4 rounded-lg px-4 py-2 font-bold {{ $userTrade->isClaimable() ? 'bg-gold-400 text-ash-900 hover:bg-gold-600 animate-pulse' : 'bg-ash-600 text-ash-400 opacity-50' }}" @disabled(! $userTrade->isClaimable())>{{ $userTrade->isClaimable() ? 'Reclamer' : 'Disponible bientot' }}</button>
    @endif
</article>
@endforeach
</div>{{ $userTrades->links() }}
@endsection
