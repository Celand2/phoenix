@extends('layouts.client')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8 overflow-hidden rounded-3xl bg-gradient-to-br from-crimson-600 via-ember-400 to-gold-400 p-8 text-white shadow-lg">
    <div class="flex flex-col items-center justify-between gap-6 md:flex-row">
        <div>
            <h2 class="text-lg font-medium text-ember-50">Bienvenue,</h2>
            <p class="text-4xl font-black md:text-5xl">{{ $user->name }}</p>
        </div>
        <div class="text-right">
            <p class="text-sm font-bold uppercase tracking-widest text-gold-50 opacity-80">Solde Total</p>
            <p class="text-4xl font-black md:text-5xl">
                {{ \App\Support\Money::formatForUser($user->balance_invested + $user->balance_gains, $user) }}
            </p>
        </div>
    </div>
</div>

<div class="grid gap-6 md:grid-cols-4">
    <div class="rounded-2xl border border-gold-100 bg-white p-6 shadow-sm transition-transform hover:scale-[1.02]">
        <p class="text-sm font-bold uppercase tracking-wider text-ash-500">Balance investie</p>
        <p class="mt-3 text-3xl font-black text-crimson-600">{{ \App\Support\Money::formatForUser($user->balance_invested, $user) }}</p>
    </div>
    <div class="rounded-2xl border border-gold-100 bg-white p-6 shadow-sm transition-transform hover:scale-[1.02]">
        <p class="text-sm font-bold uppercase tracking-wider text-ash-500">Balance gains</p>
        <p id="balance-gains" class="mt-3 text-3xl font-black text-gold-600">{{ \App\Support\Money::formatForUser($user->balance_gains, $user) }}</p>
    </div>
    <div class="rounded-2xl border border-gold-100 bg-white p-6 shadow-sm transition-transform hover:scale-[1.02]">
        <p class="text-sm font-bold uppercase tracking-wider text-ash-500">Trades actifs</p>
        <p class="mt-3 text-3xl font-black text-ash-900">{{ $activeTradesCount }}</p>
    </div>
    <div class="rounded-2xl border border-gold-100 bg-white p-6 shadow-sm transition-transform hover:scale-[1.02]">
        <p class="text-sm font-bold uppercase tracking-wider text-ash-500">Retraits pending</p>
        <p class="mt-3 text-3xl font-black text-ash-900">{{ $pendingWithdrawalsCount }}</p>
    </div>
</div>
@endsection
