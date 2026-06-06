@extends('layouts.client')

@section('title', 'Mes trades')

@section('content')
<div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-crimson-600 via-ember-400 to-gold-400 p-6 shadow-xl sm:p-10 lg:p-12 text-white">
    <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
        <div class="max-w-3xl">
            <h1 class="text-3xl font-black tracking-tight sm:text-5xl lg:text-6xl">Mes Investissements</h1>
            <p class="mt-4 text-base font-medium leading-relaxed text-white/90 sm:text-lg">Suivez vos performances et récupérez vos gains quotidiens.</p>
        </div>
        
        <div class="flex h-16 w-32 flex-col items-center justify-center rounded-2xl bg-white/10 p-2 backdrop-blur-md ring-1 ring-white/20 sm:h-20 sm:w-48">
            <p class="text-[9px] font-black uppercase tracking-widest text-gold-200 sm:text-[10px]">Contrats</p>
            <p class="text-2xl font-black sm:text-4xl">{{ $userTrades->total() }}</p>
        </div>
    </div>
</div>

<div class="grid gap-6">
@forelse($userTrades as $userTrade)
@php
    $nextClaimAt = $userTrade->last_claimed_at?->copy()?->addHours(24);
    $statusColor = match($userTrade->status) {
        'active' => 'gold',
        'expired' => 'crimson',
        default => 'ash',
    };
@endphp
<article class="group relative overflow-hidden rounded-[2rem] border border-gold-100 bg-white shadow-lg transition-all duration-300">
    <div class="flex flex-col lg:flex-row lg:items-stretch">
        <!-- Status Sidebar -->
        <div class="bg-{{ $statusColor }}-400 flex shrink-0 items-center justify-center py-3 lg:w-16 lg:py-0">
            <p class="text-[10px] font-black uppercase tracking-widest text-{{ $statusColor }}-950 lg:-rotate-90 lg:whitespace-nowrap">
                {{ strtoupper($userTrade->status) }}
            </p>
        </div>

        <div class="flex flex-1 flex-col p-6 sm:p-8">
            <div class="mb-6 flex flex-col gap-6 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-ash-400">{{ $userTrade->category?->name }}</span>
                    <h2 class="mt-1 text-2xl font-black leading-tight text-ash-900 sm:text-3xl">{{ $userTrade->trade?->name }}</h2>
                    
                    @if($userTrade->expires_at)
                    <div class="mt-3 text-sm font-medium text-ash-500">
                        @if($userTrade->status === 'active')
                            Expire le {{ $userTrade->expires_at->format('d/m/Y à H:i') }}
                        @else
                            Expiré le {{ $userTrade->expires_at->format('d/m/Y') }}
                        @endif
                    </div>
                    @endif
                </div>

                <div class="rounded-2xl bg-ash-50 px-6 py-4 text-center ring-1 ring-ash-100 sm:text-right">
                    <p class="text-[9px] font-black uppercase tracking-widest text-ash-400 sm:text-[10px]">Gain Jour</p>
                    <p class="mt-1 text-xl font-black text-gold-600 sm:text-2xl">{{ \App\Support\Money::formatForUser($userTrade->daily_gain, auth()->user()) }}</p>
                </div>
            </div>

            @if($userTrade->status === 'active')
            <div class="mt-auto flex flex-col items-center gap-4 pt-6 border-t border-ash-100 lg:flex-row lg:justify-between">
                <div>
                    @if(!$userTrade->isClaimable() && $nextClaimAt)
                    <p class="text-[10px] font-black uppercase tracking-widest text-ash-400">Prochain Trade</p>
                    <p class="text-sm font-bold text-ash-900">{{ $nextClaimAt->format('d/m/Y à H:i') }}</p>
                    @else
                    <p class="text-[10px] font-black uppercase tracking-widest text-gold-600 animate-pulse">Disponible !</p>
                    @endif
                </div>

                <button 
                    data-claim-url="{{ route('client.my-trades.claim', $userTrade) }}" 
                    data-next-claim-at="{{ $nextClaimAt?->toIso8601String() }}" 
                    data-daily-gain="{{ $userTrade->daily_gain }}"
                    data-currency="{{ auth()->user()->preferred_currency ?? 'USD' }}"
                    data-rate="{{ auth()->user()->preferred_rate ?? 1 }}"
                    class="claim-button flex w-full items-center justify-center rounded-2xl py-4 text-lg font-black transition-all lg:w-auto lg:px-10 {{ $userTrade->isClaimable() ? 'bg-gold-400 text-gold-950 hover:bg-gold-500 shadow-lg' : 'bg-ash-100 text-ash-400 cursor-not-allowed' }}" 
                    @disabled(! $userTrade->isClaimable())
                >
                    Trade
                </button>
            </div>
            @endif
        </div>
    </div>
</article>
@empty
<div class="rounded-3xl border-2 border-dashed border-gold-200 bg-white/50 py-16 text-center">
    <h3 class="text-xl font-black text-ash-900 sm:text-2xl">Aucun trade actif</h3>
    <p class="mt-4 text-sm font-medium text-ash-500 sm:text-base">Commencez votre aventure financière maintenant.</p>
    <a href="{{ route('client.categories.index') }}" class="mt-8 inline-flex items-center rounded-2xl bg-crimson-600 px-8 py-4 text-lg font-black text-white shadow-xl transition-all hover:bg-crimson-700">
        Découvrir les Trades
    </a>
</div>
@endforelse
</div>

@if($userTrades->hasPages())
<div class="mt-10">
    {{ $userTrades->links() }}
</div>
@endif
@endsection
