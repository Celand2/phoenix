@extends('layouts.client')

@section('title', 'Categories')

@section('content')
<div class="relative mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-crimson-600 via-ember-400 to-gold-400 px-6 py-10 text-white shadow-xl sm:px-10 sm:py-16">
    <div class="relative z-10">
        <h1 class="text-3xl font-black tracking-tight sm:text-5xl">Marché des Trades</h1>
        <p class="mt-3 max-w-2xl text-base font-medium text-white/90 sm:mt-4 sm:text-lg">Explorez nos catégories exclusives et commencez à générer des profits quotidiens dès aujourd'hui.</p>
    </div>
</div>

<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
@forelse($categories as $category)
<article class="group relative flex flex-col overflow-hidden rounded-3xl border border-gold-100 bg-white shadow-lg transition-all duration-300 hover:-translate-y-2 hover:border-gold-300">
    <div class="h-2 bg-gradient-to-r from-crimson-600 to-gold-400"></div>
    
    <div class="flex flex-1 flex-col p-6 sm:p-8">
        <div class="mb-6 flex items-start justify-between">
            <span class="rounded-lg bg-ash-900 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-white">Catégorie</span>
            <span class="rounded-full bg-crimson-50 px-4 py-1.5 text-[10px] font-black uppercase tracking-widest text-crimson-600">Premium</span>
        </div>

        <h2 class="text-2xl font-black leading-tight text-ash-900 group-hover:text-crimson-600 transition-colors sm:text-3xl">{{ $category->name }}</h2>
        
        @if($category->description)
            <p class="mt-4 line-clamp-2 text-sm font-medium leading-relaxed text-ash-500 sm:text-base">{{ $category->description }}</p>
        @endif

        <div class="mt-8 grid grid-cols-2 gap-3 sm:gap-4">
            <div class="rounded-2xl bg-gold-50 p-4 ring-1 ring-gold-100 sm:p-5">
                <p class="text-[9px] font-black uppercase tracking-wider text-gold-600 sm:text-[10px]">Profit / Jour</p>
                <p class="mt-1 text-xl font-black text-gold-700 sm:text-2xl">+{{ number_format((float) $category->daily_profit_percent, 2) }}%</p>
            </div>

            <div class="rounded-2xl bg-ash-50 p-4 ring-1 ring-ash-100 sm:p-5">
                <p class="text-[9px] font-black uppercase tracking-wider text-ash-400 sm:text-[10px]">Durée</p>
                <p class="mt-1 text-xl font-black text-ash-900 sm:text-2xl">{{ $category->duration_days }} <span class="text-sm font-bold text-ash-400">J</span></p>
            </div>
        </div>

        <div class="mt-8 flex items-center gap-3">
            <div class="h-px flex-1 bg-ash-100"></div>
            <span class="text-[10px] font-bold uppercase tracking-widest text-ash-400">{{ $category->active_trades_count }} Actifs</span>
            <div class="h-px flex-1 bg-ash-100"></div>
        </div>

        <div class="mt-8">
            <a href="{{ route('client.categories.show', $category) }}" class="flex w-full items-center justify-center rounded-2xl bg-ash-900 py-4 text-base font-black text-white shadow-lg transition-all hover:bg-crimson-600 active:scale-[0.98] sm:py-5 sm:text-lg">
                Explorer
            </a>
        </div>
    </div>
</article>
@empty
<div class="col-span-full rounded-3xl border-2 border-dashed border-gold-200 bg-gold-50/50 py-16 text-center">
    <h3 class="text-xl font-black text-ash-900 sm:text-2xl">Aucune catégorie disponible</h3>
    <p class="mt-2 text-sm font-medium text-ash-500 sm:text-base">Revenez plus tard pour découvrir de nouvelles opportunités.</p>
</div>
@endforelse
</div>

@if($categories->hasPages())
<div class="mt-10">
    {{ $categories->links() }}
</div>
@endif
@endsection
