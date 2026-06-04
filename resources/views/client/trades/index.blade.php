@extends('layouts.client')

@section('title', 'Trades disponibles')

@section('content')
<div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-crimson-600 via-ember-400 to-gold-400 p-6 shadow-xl sm:p-10 lg:p-12 text-white">
    <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
        <div class="max-w-3xl">
            <h1 class="text-3xl font-black tracking-tight sm:text-5xl lg:text-6xl">Tous les Trades</h1>
            <p class="mt-4 text-base font-medium leading-relaxed text-white/90 sm:text-lg">Découvrez l'ensemble de nos opportunités d'investissement à travers toutes les catégories.</p>
        </div>
        
        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/10 backdrop-blur-md ring-1 ring-white/20 sm:h-20 sm:w-20">
            <span class="text-2xl font-black text-gold-400 sm:text-4xl">$</span>
        </div>
    </div>
</div>

<div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
@forelse($trades as $trade)
<article class="group relative flex flex-col overflow-hidden rounded-[2rem] border border-gold-100 bg-white p-1.5 shadow-lg transition-all duration-300 hover:-translate-y-2">
    <div class="flex flex-1 flex-col rounded-[1.8rem] bg-ash-50 p-6 sm:p-8">
        <div class="mb-6 flex items-center justify-between">
            <span class="rounded-lg bg-gold-400/10 px-3 py-1 text-[9px] font-black uppercase tracking-widest text-gold-600 ring-1 ring-gold-400/20 sm:text-[10px]">
                {{ $trade->category?->name ?? 'Général' }}
            </span>
            <div class="text-right">
                <p class="text-[9px] font-black uppercase tracking-widest text-ash-400 sm:text-[10px]">Prix</p>
                <p class="mt-0.5 text-lg font-black text-ash-900 sm:text-xl">{{ \App\Support\Money::formatForUser($trade->amount, auth()->user()) }}</p>
            </div>
        </div>

        <h2 class="mb-6 text-2xl font-black leading-tight text-ash-900 group-hover:text-crimson-600 transition-colors sm:text-3xl">{{ $trade->name }}</h2>

        <div class="mb-8 grid grid-cols-2 gap-3 sm:gap-4">
            <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gold-100 sm:p-5">
                <p class="text-[9px] font-black uppercase tracking-widest text-ash-400 sm:text-[10px]">Profit Jour</p>
                <p class="mt-1 text-base font-black text-gold-600 sm:text-lg">{{ \App\Support\Money::formatForUser($trade->dailyGain(), auth()->user()) }}</p>
            </div>
            <div class="rounded-xl bg-white p-4 shadow-sm ring-1 ring-gold-100 sm:p-5">
                <p class="text-[9px] font-black uppercase tracking-widest text-ash-400 sm:text-[10px]">Durée</p>
                <p class="mt-1 text-base font-black text-ash-900 sm:text-lg">{{ $trade->category?->duration_days ?? 'N/A' }} <span class="text-xs text-ash-400">J</span></p>
            </div>
        </div>

        <form class="mt-auto" method="POST" action="{{ route('client.trades.buy', $trade) }}">
            @csrf
            <button class="flex w-full items-center justify-center rounded-2xl bg-crimson-600 py-4 text-lg font-black text-black shadow-lg transition-all hover:bg-crimson-700 active:scale-[0.98] sm:py-5 sm:text-xl">
                Acheter
            </button>
        </form>
    </div>
</article>
@empty
<div class="col-span-full rounded-3xl border-2 border-dashed border-gold-200 bg-white/50 py-16 text-center">
    <h3 class="text-xl font-black text-ash-900 sm:text-2xl">Aucun trade disponible</h3>
    <p class="mt-4 text-sm font-medium text-ash-500 sm:text-base">Revenez plus tard pour découvrir nos nouvelles offres.</p>
</div>
@endforelse
</div>

@if($trades->hasPages())
<div class="mt-10">
    {{ $trades->links() }}
</div>
@endif
@endsection
