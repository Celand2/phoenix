@extends('layouts.client')

@section('title', 'Retraits')

@section('content')
@php($user = auth()->user())
<form method="POST" action="{{ route('client.withdrawals.store') }}" class="mb-6 grid gap-3 rounded-lg border border-ash-600 bg-ash-800 p-4" data-money-converter>@csrf
<select class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="payment_method_id" data-money-method>
@foreach($paymentMethods as $method)
@php($snapshot = \App\Support\Money::snapshotFor($method))
<option value="{{ $method->id }}" data-rate="{{ $snapshot['rate'] }}" data-currency="{{ $snapshot['currency'] }}">{{ $method->name }} - {{ $snapshot['currency'] }}</option>
@endforeach
</select>
<input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="amount" type="number" step="0.01" placeholder="Montant {{ $user->preferred_currency ?: 'USD' }}" data-money-input data-user-rate="{{ $user->preferred_rate }}" data-user-currency="{{ $user->preferred_currency }}">
<p class="text-sm text-ash-200">
    @if($user->preferred_currency)
        Le montant est saisi en {{ $user->preferred_currency }}. Il sera converti en USD au taux fixe de votre premiere methode.
    @else
        Avant votre premier choix de methode, le montant est saisi en USD.
    @endif
</p>
<input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="account_number" placeholder="Numero compte">
<input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="account_name" placeholder="Nom compte">
<button class="rounded-lg bg-crimson-400 px-4 py-2 font-semibold text-white">Demander</button></form>
<div class="overflow-x-auto rounded-lg border border-ash-600 bg-ash-800"><table class="w-full text-left text-sm"><thead class="bg-ash-900 text-ash-200"><tr><th class="p-3">Methode</th><th>Demande</th><th>Frais</th><th>Recu</th><th>Statut</th></tr></thead><tbody>@foreach($withdrawals as $withdrawal)<tr class="border-t border-ash-600"><td class="p-3">{{ $withdrawal->paymentMethod?->name }}</td><td>{{ \App\Support\Money::formatSnapshot($withdrawal->amount_requested, $withdrawal->amount_requested_local, $withdrawal->currency_local) }}</td><td>{{ \App\Support\Money::formatSnapshot($withdrawal->fee, $withdrawal->fee_local, $withdrawal->currency_local) }}</td><td class="text-gold-400">{{ \App\Support\Money::formatSnapshot($withdrawal->amount_received, $withdrawal->amount_received_local, $withdrawal->currency_local) }}</td><td>{{ $withdrawal->status }}</td></tr>@endforeach</tbody></table></div>{{ $withdrawals->links() }}
@endsection
