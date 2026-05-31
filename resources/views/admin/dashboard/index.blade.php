@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-black text-ash-900">Vue d'ensemble</h1>
    <p class="text-ash-500 italic">Résumé de l'activité de la plateforme.</p>
</div>

<div class="grid gap-6 md:grid-cols-4">
    @foreach ([
        'Utilisateurs' => ['val' => $usersCount, 'color' => 'text-ash-900'],
        'Trades actifs' => ['val' => $activeTradesCount, 'color' => 'text-gold-600'],
        'Dépôts pending' => ['val' => $pendingDepositsCount, 'color' => 'text-crimson-600'],
        'Retraits pending' => ['val' => $pendingWithdrawalsCount, 'color' => 'text-crimson-600'],
    ] as $label => $data)
        <div class="rounded-2xl border border-gold-100 bg-white p-6 shadow-sm transition-all hover:shadow-md">
            <p class="text-xs font-bold uppercase tracking-widest text-ash-400">{{ $label }}</p>
            <p class="mt-3 text-4xl font-black {{ $data['color'] }}">{{ $data['val'] }}</p>
            <div class="mt-4 flex items-center gap-2">
                <span class="size-2 rounded-full {{ str_contains($label, 'pending') ? 'bg-crimson-400 animate-pulse' : 'bg-gold-400' }}"></span>
                <span class="text-[10px] font-bold uppercase text-ash-400 tracking-tighter">Mise à jour à l'instant</span>
            </div>
        </div>
    @endforeach
</div>
@endsection
