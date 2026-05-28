@extends('layouts.client')

@section('title', 'Dashboard')

@section('content')
<div class="grid gap-4 md:grid-cols-4">
    <div class="rounded-lg border border-ash-600 bg-ash-800 p-5"><p class="text-sm text-ash-200">Balance investie</p><p class="mt-2 text-3xl font-bold text-crimson-400">{{ $user->balance_invested }}</p></div>
    <div class="rounded-lg border border-ash-600 bg-ash-800 p-5"><p class="text-sm text-ash-200">Balance gains</p><p id="balance-gains" class="mt-2 text-3xl font-bold text-gold-400">{{ $user->balance_gains }}</p></div>
    <div class="rounded-lg border border-ash-600 bg-ash-800 p-5"><p class="text-sm text-ash-200">Trades actifs</p><p class="mt-2 text-3xl font-bold text-gold-400">{{ $activeTradesCount }}</p></div>
    <div class="rounded-lg border border-ash-600 bg-ash-800 p-5"><p class="text-sm text-ash-200">Retraits pending</p><p class="mt-2 text-3xl font-bold text-gold-400">{{ $pendingWithdrawalsCount }}</p></div>
</div>
@endsection
