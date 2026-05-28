@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid gap-4 md:grid-cols-4">
    @foreach ([
        'Utilisateurs' => $usersCount,
        'Trades actifs' => $activeTradesCount,
        'Depots pending' => $pendingDepositsCount,
        'Retraits pending' => $pendingWithdrawalsCount,
    ] as $label => $value)
        <div class="rounded-lg border border-ash-600 bg-ash-800 p-5">
            <p class="text-sm text-ash-200">{{ $label }}</p>
            <p class="mt-2 text-3xl font-bold text-gold-400">{{ $value }}</p>
        </div>
    @endforeach
</div>
@endsection
