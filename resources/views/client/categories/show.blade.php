@extends('layouts.client')

@section('title', $category->name)

@section('content')
<div class="mb-6">
    <a href="{{ route('client.categories.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-ash-900 px-5 py-2.5 text-sm font-black text-white shadow-sm transition-all hover:bg-crimson-600">
        Retour au Marché
    </a>
</div>

<section class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-crimson-600 via-ember-400 to-gold-400 p-6 shadow-xl sm:p-10 lg:p-12 text-white">
    <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
        <div class="max-w-3xl">
            <span class="inline-block rounded-lg bg-white/20 px-3 py-1 text-[10px] font-black uppercase tracking-widest">Catégorie</span>
            <h1 class="mt-4 text-3xl font-black tracking-tight sm:text-5xl lg:text-6xl">{{ $category->name }}</h1>
            @if($category->description)
                <p class="mt-4 text-base font-medium leading-relaxed text-white/90 sm:text-lg">{{ $category->description }}</p>
            @endif
        </div>

        <div class="grid grid-cols-2 gap-3 sm:flex sm:items-center sm:gap-4 lg:gap-6">
            <div class="rounded-2xl bg-white/10 p-4 backdrop-blur-md ring-1 ring-white/20 sm:min-w-[8rem] sm:p-6">
                <p class="text-[9px] font-black uppercase tracking-wider text-white/70 sm:text-[10px]">Profit Jour</p>
                <p class="mt-1 text-xl font-black sm:text-3xl">+{{ number_format((float) $category->daily_profit_percent, 2) }}%</p>
            </div>
            <div class="rounded-2xl bg-white/10 p-4 backdrop-blur-md ring-1 ring-white/20 sm:min-w-[8rem] sm:p-6">
                <p class="text-[9px] font-black uppercase tracking-wider text-white/70 sm:text-[10px]">Période</p>
                <p class="mt-1 text-xl font-black sm:text-3xl">{{ $category->duration_days }} <span class="text-sm font-bold opacity-70">J</span></p>
            </div>
        </div>
    </div>
</section>

<div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
@forelse($trades as $trade)
<article class="group relative flex flex-col overflow-hidden rounded-[2rem] border border-gold-100 bg-white p-1.5 shadow-lg transition-all duration-300 hover:-translate-y-2">
    <div class="flex flex-1 flex-col rounded-[1.8rem] bg-ash-50 p-6 sm:p-8">
        <div class="mb-6 flex items-center justify-between">
            <span class="rounded-lg bg-white px-3 py-1 text-[9px] font-black uppercase tracking-widest text-ash-900 shadow-sm sm:text-[10px]">Trade</span>
            <div class="text-right">
                <p class="text-[9px] font-black uppercase tracking-widest text-ash-400 sm:text-[10px]">Investissement</p>
                <p class="mt-0.5 text-lg font-black text-ash-900 sm:text-xl">{{ \App\Support\Money::formatForUser($trade->amount, auth()->user()) }}</p>
            </div>
        </div>

        <h2 class="mb-6 text-2xl font-black leading-tight text-ash-900 group-hover:text-crimson-600 transition-colors sm:text-3xl">{{ $trade->name }}</h2>

        <div class="mb-8 space-y-3">
            <div class="flex items-center justify-between rounded-xl bg-white px-4 py-3 shadow-sm ring-1 ring-gold-100 sm:px-5 sm:py-4">
                <span class="text-[10px] font-bold uppercase tracking-widest text-ash-400">Gain Quotidien</span>
                <span class="text-lg font-black text-gold-600 sm:text-xl">{{ \App\Support\Money::formatForUser($trade->dailyGain(), auth()->user()) }}</span>
            </div>
            <div class="flex items-center justify-between rounded-xl bg-white px-4 py-3 shadow-sm ring-1 ring-gold-100 sm:px-5 sm:py-4">
                <span class="text-[10px] font-bold uppercase tracking-widest text-ash-400">Rendement Total</span>
                <span class="text-lg font-black text-crimson-600 sm:text-xl">+{{ number_format((float) ($category->daily_profit_percent * $category->duration_days), 2) }}%</span>
            </div>
        </div>

        <form class="mt-auto" method="POST" action="{{ route('client.trades.buy', $trade) }}">
            @csrf
            <button class="flex w-full items-center justify-center rounded-2xl bg-crimson-600 py-4 text-lg font-black text-white shadow-lg transition-all hover:bg-crimson-700 active:scale-[0.98] sm:py-5 sm:text-xl">
                Acheter
            </button>
        </form>
    </div>
</article>
@empty
<div class="col-span-full rounded-3xl border-2 border-dashed border-gold-200 bg-white/50 py-16 text-center">
    <h3 class="text-xl font-black text-ash-900 sm:text-2xl">Aucun trade disponible</h3>
    <p class="mt-4 text-sm font-medium text-ash-500 sm:text-base">Revenez bientôt pour de nouvelles opportunités.</p>
</div>
@endforelse
</div>

@if($trades->hasPages())
<div class="mt-10">
    {{ $trades->links() }}
</div>
@endif
@endsection
