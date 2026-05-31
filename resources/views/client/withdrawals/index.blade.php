@extends('layouts.client')

@section('title', 'Retraits')

@section('content')
@php($user = auth()->user())
<div class="mb-8">
    <h1 class="mb-6 text-2xl font-black text-ash-900">Demander un retrait</h1>
    <form method="POST" action="{{ route('client.withdrawals.store') }}" class="grid gap-6 rounded-2xl border border-gold-100 bg-white p-8 shadow-sm" data-money-converter>
        @csrf
        <div class="grid gap-4 md:grid-cols-2">
            <div class="grid gap-2">
                <label class="text-sm font-bold uppercase tracking-wider text-ash-500">Méthode de réception</label>
                <select class="rounded-xl border border-ash-200 bg-white px-4 py-3 text-ash-900 focus:border-crimson-400 focus:ring-crimson-400" name="payment_method_id" data-money-method>
                    @foreach($paymentMethods as $method)
                        @php($snapshot = \App\Support\Money::snapshotFor($method))
                        <option value="{{ $method->id }}" data-rate="{{ $snapshot['rate'] }}" data-currency="{{ $snapshot['currency'] }}">
                            {{ $method->name }} ({{ $snapshot['currency'] }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="grid gap-2">
                <label class="text-sm font-bold uppercase tracking-wider text-ash-500">Montant à retirer ({{ $user->preferred_currency ?: 'USD' }})</label>
                <input class="rounded-xl border border-ash-200 bg-white px-4 py-3 text-ash-900 focus:border-crimson-400 focus:ring-crimson-400 font-bold" name="amount" type="number" step="0.01" placeholder="0.00" data-money-input data-user-rate="{{ $user->preferred_rate }}" data-user-currency="{{ $user->preferred_currency }}">
            </div>
        </div>

        <div class="rounded-xl bg-gold-50 p-4 text-xs font-medium text-gold-800">
            @if($user->preferred_currency)
                Le montant est saisi en <strong>{{ $user->preferred_currency }}</strong>. Il sera converti en USD au taux de change actuel.
            @else
                Le montant est saisi en <strong>USD</strong>.
            @endif
            <p class="mt-1 text-ash-500">Le montant minimum est de <strong>0.25 USD</strong>.</p>
            <p class="mt-1 text-ash-500 italic">* Des frais de retrait peuvent s'appliquer selon la méthode choisie.</p>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="grid gap-2">
                <label class="text-sm font-bold uppercase tracking-wider text-ash-500">Numéro de compte / Identifiant</label>
                <input class="rounded-xl border border-ash-200 bg-white px-4 py-3 text-ash-900 focus:border-crimson-400 focus:ring-crimson-400" name="account_number" placeholder="Ex: 0123456789">
            </div>
            <div class="grid gap-2">
                <label class="text-sm font-bold uppercase tracking-wider text-ash-500">Nom du compte / Titulaire</label>
                <input class="rounded-xl border border-ash-200 bg-white px-4 py-3 text-ash-900 focus:border-crimson-400 focus:ring-crimson-400" name="account_name" placeholder="Ex: Jean Dupont">
            </div>
        </div>

        <button class="w-full rounded-xl bg-crimson-400 px-6 py-4 font-black text-white transition-all hover:bg-crimson-600 hover:shadow-xl active:scale-95 md:w-max md:px-12">
            Soumettre la demande
        </button>
    </form>
</div>

<div class="mt-12">
    <h2 class="mb-6 text-xl font-black text-ash-900">Historique des retraits</h2>
    <div class="overflow-hidden rounded-2xl border border-gold-100 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gold-50 text-xs font-bold uppercase tracking-wider text-ash-500">
                    <tr>
                        <th class="p-4">Méthode</th>
                        <th class="p-4">Demande</th>
                        <th class="p-4">Frais</th>
                        <th class="p-4">Reçu</th>
                        <th class="p-4">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gold-100 text-ash-900">
                    @forelse($withdrawals as $withdrawal)
                    <tr class="transition-colors hover:bg-gold-50/50">
                        <td class="p-4 font-medium">{{ $withdrawal->paymentMethod?->name }}</td>
                        <td class="p-4 text-ash-500">{{ \App\Support\Money::formatSnapshot($withdrawal->amount_requested, $withdrawal->amount_requested_local, $withdrawal->currency_local) }}</td>
                        <td class="p-4 text-crimson-600/70 font-medium">-{{ \App\Support\Money::formatSnapshot($withdrawal->fee, $withdrawal->fee_local, $withdrawal->currency_local) }}</td>
                        <td class="p-4 text-gold-600 font-black">{{ \App\Support\Money::formatSnapshot($withdrawal->amount_received, $withdrawal->amount_received_local, $withdrawal->currency_local) }}</td>
                        <td class="p-4">
                            @php
                                $badgeClass = match($withdrawal->status) {
                                    'approved', 'completed' => 'bg-gold-100 text-gold-800',
                                    'rejected', 'cancelled' => 'bg-crimson-100 text-crimson-800',
                                    default => 'bg-ash-100 text-ash-600',
                                };
                            @endphp
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $badgeClass }}">
                                {{ ucfirst($withdrawal->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center text-ash-400">
                            Aucune demande de retrait effectuée.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-8">
        {{ $withdrawals->links() }}
    </div>
</div>
@endsection
