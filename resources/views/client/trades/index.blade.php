@extends('layouts.client')

@section('title', 'Trades disponibles')

@section('content')
<div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
@foreach($trades as $trade)
<article class="flex flex-col rounded-2xl border border-gold-100 bg-white p-6 shadow-sm transition-transform hover:scale-[1.02]">
    <span class="text-xs font-bold uppercase tracking-wider text-ash-400">{{ $trade->category?->name }}</span>
    <h2 class="mt-2 text-2xl font-black text-ash-900">{{ $trade->name }}</h2>
    
    <div class="my-6 space-y-1">
        <p class="text-3xl font-black text-crimson-600">{{ \App\Support\Money::formatForUser($trade->amount, auth()->user()) }}</p>
        <p class="text-sm font-bold text-gold-600">Gain journalier: {{ \App\Support\Money::formatForUser($trade->dailyGain(), auth()->user()) }}</p>
    </div>

    <form class="mt-auto" method="POST" action="{{ route('client.trades.buy', $trade) }}">
        @csrf
        <button class="w-full rounded-xl bg-crimson-400 px-6 py-3 font-bold text-white transition-all hover:bg-crimson-600 hover:shadow-lg active:scale-95">
            Acheter maintenant
        </button>
    </form>
</article>
@endforeach
</div>
<div class="mt-8">
    {{ $trades->links() }}
</div>
@endsection
