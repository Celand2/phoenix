@extends('layouts.client')

@section('title', $category->name)

@section('content')
<div class="mb-6">
    <a href="{{ route('client.categories.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-ash-900 px-5 py-2.5 text-sm font-black text-white shadow-sm transition-all hover:bg-crimson-600">
        Retour au Marché
    </a>
</div>

<section class="relative mb-8 overflow-hidden rounded-3xl bg-ash-900 p-6 shadow-xl sm:p-10 lg:p-12 text-white">
    {{-- Glows --}}
    <div class="pointer-events-none absolute -right-10 -top-10 h-56 w-56 rounded-full bg-crimson-600/40 blur-3xl"></div>
    <div class="pointer-events-none absolute -left-6 bottom-0 h-40 w-40 rounded-full bg-gold-400/25 blur-3xl"></div>

    <div class="relative z-10 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
        <div class="max-w-3xl">
            <span class="inline-flex items-center gap-2 rounded-lg border border-white/10 bg-white/5 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-white/50">
                <span class="size-1.5 rounded-full bg-crimson-500 shadow-[0_0_6px_theme(colors.crimson.500)]"></span>
                Categorie active
            </span>
            <h1 class="mt-4 text-3xl font-black tracking-tight sm:text-5xl lg:text-6xl">{{ $category->name }}</h1>
            @if($category->description)
                <p class="mt-4 text-base font-medium leading-relaxed text-white/40 sm:text-lg">{{ $category->description }}</p>
            @endif
        </div>

        <div class="grid grid-cols-2 gap-3 sm:flex sm:items-center sm:gap-4 lg:gap-6">
            <div class="rounded-2xl border border-white/10 bg-white/5 p-4 sm:min-w-[8rem] sm:p-6">
                <p class="text-[9px] font-black uppercase tracking-wider text-white/30 sm:text-[10px]">Profit Jour</p>
                <p class="mt-1 text-xl font-black sm:text-3xl">+{{ number_format((float) $category->daily_profit_percent, 2) }}%</p>
            </div>
            <div class="rounded-2xl border border-white/10 bg-white/5 p-4 sm:min-w-[8rem] sm:p-6">
                <p class="text-[9px] font-black uppercase tracking-wider text-white/30 sm:text-[10px]">Periode</p>
                <p class="mt-1 text-xl font-black sm:text-3xl">{{ $category->duration_days }} <span class="text-sm font-bold opacity-40">J</span></p>
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
            <div class="flex items-center justify-between rounded-xl bg-white px-4 py-3 shadow-sm ring-1 ring-gold-900 sm:px-3 sm:py-2">
                <span class="text-[10px] font-bold uppercase tracking-widest text-ash-400">Gain Quotidien</span>
                <span class="text-lg font-black text-gold-600 sm:text-xl">{{ \App\Support\Money::formatForUser($trade->dailyGain(), auth()->user()) }}</span>
            </div>
            <div class="flex items-center justify-between rounded-xl bg-white px-4 py-3 shadow-sm ring-1 ring-gold-100 sm:px-3 sm:py-2">
                <span class="text-[10px] font-bold uppercase tracking-widest text-ash-400">Rendement Total</span>
                <span class="text-lg font-black text-crimson-600 sm:text-xl">+{{ number_format((float) ($category->daily_profit_percent * $category->duration_days), 2) }}%</span>
            </div>
        </div>

        {{-- Bouton Acheter brillant --}}
        <form class="mt-auto" method="POST" action="{{ route('client.trades.buy', $trade) }}">
            @csrf
            <button type="submit" class="group/btn relative w-full overflow-hidden rounded-2xl bg-gradient-to-b from-crimson-500 to-crimson-700 py-4 shadow-[0_0_0_1px_rgba(255,255,255,0.12)_inset,0_1px_0_rgba(255,255,255,0.25)_inset,0_4px_14px_rgba(220,38,38,0.45)] transition-transform active:scale-[0.97] sm:py-5">
                {{-- reflet haut --}}
                <span class="pointer-events-none absolute inset-x-[5%] top-0 h-2/5 rounded-b-full bg-gradient-to-b from-white/25 to-transparent"></span>
                {{-- lueur basse --}}
                <span class="pointer-events-none absolute inset-x-[20%] bottom-0 h-1/3 rounded-full bg-orange-400/30 blur-xl"></span>

                <span class="relative flex items-center justify-center gap-2 ">
                    <span class="text-base drop-shadow-[0_0_4px_rgba(255,200,150,0.6)]">⚡</span>
                    <span class="text-lg font-black tracking-wide text-white drop-shadow-sm sm:text-xl">Acheter</span>
                </span>
            </button>
        </form>
    </div>
</article>
@empty
<div class="col-span-full rounded-3xl border-2 border-dashed border-gold-200 bg-white/50 py-16 text-center">
    <h3 class="text-xl font-black text-ash-900 sm:text-2xl">Aucun trade disponible</h3>
    <p class="mt-4 text-sm font-medium text-ash-500 sm:text-base">Revenez bientot pour de nouvelles opportunites.</p>
</div>
@endforelse
</div>

@if($trades->hasPages())
<div class="mt-10">
    {{ $trades->links() }}
</div>
@endif
@endsection