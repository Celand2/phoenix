@extends('layouts.admin')

@section('title', 'Taux de change')

@section('content')
<form method="POST" action="{{ route('admin.exchange-rates.store') }}" class="mb-6 grid gap-3 rounded-lg border border-ash-600 bg-ash-800 p-4 md:grid-cols-5">@csrf
<input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="currency_from" placeholder="From"><input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="currency_to" placeholder="To"><input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="rate" type="number" step="0.000001" placeholder="Rate"><label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" checked> Actif</label><button class="rounded-lg bg-crimson-400 px-4 py-2 font-semibold text-white">Ajouter</button></form>
<div class="overflow-x-auto rounded-lg border border-ash-600 bg-ash-800"><table class="w-full text-left text-sm"><thead class="bg-ash-900 text-ash-200"><tr><th class="p-3">From</th><th>To</th><th>Rate</th><th>Actif</th></tr></thead><tbody>@foreach($exchangeRates as $rate)<tr class="border-t border-ash-600"><td class="p-3">{{ $rate->currency_from }}</td><td>{{ $rate->currency_to }}</td><td class="text-gold-400">{{ $rate->rate }}</td><td>{{ $rate->is_active ? 'Oui' : 'Non' }}</td></tr>@endforeach</tbody></table></div>{{ $exchangeRates->links() }}
@endsection
