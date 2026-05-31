@extends('layouts.client')
@section('title', 'Mes trades')
@section('content')
<div class="grid gap-6">
@forelse($userTrades as $userTrade)
@php($nextClaimAt = $userTrade->last_claimed_at?->copy()->addHours(24))
<article class="rounded-2xl border border-gold-100 bg-white p-6 shadow-sm">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-black text-ash-900">{{ $userTrade->trade?->name }}</h2>
            <p class="text-sm font-medium text-ash-500">
                <span class="uppercase tracking-wider">{{ $userTrade->category?->name }}</span>
                <span class="mx-2 text-ash-300">•</span>
                @php
                    $statusClass = match($userTrade->status) {
                        'active' => 'text-gold-600',
                        'expired' => 'text-crimson-600',
                        default => 'text-ash-400',
                    };
                @endphp
                <span class="font-bold {{ $statusClass }}">{{ strtoupper($userTrade->status) }}</span>
            </p>
            @if($userTrade->expires_at)
                <p class="mt-1 text-xs text-ash-400">
                    @if($userTrade->status === 'active')
                        Expire le {{ $userTrade->expires_at->format('d/m/Y à H:i') }}
                    @else
                        Expiré le {{ $userTrade->expires_at->format('d/m/Y') }}
                    @endif
                </p>
            @endif
        </div>
        <div class="text-right">
            <p class="text-2xl font-black text-gold-600">{{ \App\Support\Money::formatForUser($userTrade->daily_gain, auth()->user()) }}</p>
            <p class="text-xs font-bold uppercase tracking-widest text-ash-400">par jour</p>
        </div>
    </div>
    
    @if($userTrade->status === 'active')
    <div class="mt-6 flex flex-col gap-2">
        <button 
            data-claim-url="{{ route('client.my-trades.claim', $userTrade) }}" 
            data-next-claim-at="{{ $nextClaimAt?->toIso8601String() }}" 
            class="claim-button w-full rounded-xl py-3 font-black transition-all md:w-max md:px-8 {{ $userTrade->isClaimable() ? 'bg-gold-400 text-gold-900 hover:bg-gold-600 hover:shadow-lg animate-pulse' : 'bg-ash-100 text-ash-400 cursor-not-allowed opacity-60' }}" 
            @disabled(! $userTrade->isClaimable())
        >
            {{ $userTrade->isClaimable() ? 'Réclamer mes gains' : 'Disponible bientôt' }}
        </button>
        @if(!$userTrade->isClaimable() && $nextClaimAt)
            <p class="text-xs font-medium text-ash-400">Prochaine réclamation prévue le {{ $nextClaimAt->format('d/m/Y à H:i') }}</p>
        @endif
    </div>
    @endif
</article>
@empty
<div class="flex flex-col items-center justify-center rounded-2xl border border-gold-100 bg-white p-12 text-center shadow-sm">
    <div class="mb-4 text-4xl text-ash-200">📊</div>
    <p class="text-lg font-bold text-ash-900">Vous n'avez aucun trade pour le moment.</p>
    <a href="{{ route('client.trades.index') }}" class="mt-4 text-sm font-bold text-crimson-600 hover:underline">Voir les opportunités</a>
</div>
@endforelse
</div>
<div class="mt-8">
    {{ $userTrades->links() }}
</div>
@endsection