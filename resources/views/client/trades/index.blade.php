@extends('layouts.client')

@section('title', 'Trades disponibles')

@section('content')
<div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
@foreach($trades as $trade)
<article class="rounded-lg border border-ash-600 bg-ash-800 p-5">
    <p class="text-sm text-ash-200">{{ $trade->category?->name }}</p>
    <h2 class="mt-1 text-xl font-bold">{{ $trade->name }}</h2>
    <p class="mt-3 text-2xl font-bold text-crimson-400">{{ $trade->amount }}</p>
    <p class="text-sm text-gold-400">Gain journalier: {{ $trade->dailyGain() }}</p>
    <form class="mt-4" method="POST" action="{{ route('client.trades.buy', $trade) }}">@csrf<button class="rounded-lg bg-crimson-400 px-4 py-2 font-semibold text-white hover:bg-crimson-600">Acheter</button></form>
</article>
@endforeach
</div>{{ $trades->links() }}
@endsection
