@extends('layouts.client')

@section('title', 'Retraits')

@section('content')
<form method="POST" action="{{ route('client.withdrawals.store') }}" class="mb-6 grid gap-3 rounded-lg border border-ash-600 bg-ash-800 p-4">@csrf
<select class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="payment_method_id">@foreach($paymentMethods as $method)<option value="{{ $method->id }}">{{ $method->name }}</option>@endforeach</select>
<input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="amount" type="number" step="0.01" placeholder="Montant">
<input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="account_number" placeholder="Numero compte">
<input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="account_name" placeholder="Nom compte">
<button class="rounded-lg bg-crimson-400 px-4 py-2 font-semibold text-white">Demander</button></form>
<div class="overflow-x-auto rounded-lg border border-ash-600 bg-ash-800"><table class="w-full text-left text-sm"><thead class="bg-ash-900 text-ash-200"><tr><th class="p-3">Methode</th><th>Demande</th><th>Recu</th><th>Statut</th></tr></thead><tbody>@foreach($withdrawals as $withdrawal)<tr class="border-t border-ash-600"><td class="p-3">{{ $withdrawal->paymentMethod?->name }}</td><td>{{ $withdrawal->amount_requested }}</td><td class="text-gold-400">{{ $withdrawal->amount_received }}</td><td>{{ $withdrawal->status }}</td></tr>@endforeach</tbody></table></div>{{ $withdrawals->links() }}
@endsection
