@extends('layouts.admin')
@section('title', 'Trades')
@section('content')
<div class="mb-4"><a class="rounded-lg bg-crimson-400 px-4 py-2 font-semibold text-white hover:bg-crimson-600" href="{{ route('admin.trades.create') }}">Nouveau trade</a></div>
<div class="overflow-x-auto rounded-lg border border-ash-600 bg-ash-800">
<table class="w-full min-w-[600px] text-left text-sm"><thead class="bg-ash-900 text-ash-200"><tr><th class="p-3">Nom</th><th>Categorie</th><th>Montant</th><th>Actif</th><th class="p-3 text-right">Action</th></tr></thead><tbody>
@forelse ($trades as $trade)
<tr class="border-t border-ash-600"><td class="p-3">{{ $trade->name }}</td><td>{{ $trade->category?->name }}</td><td class="text-gold-400">{{ \App\Support\Money::formatUsd($trade->amount) }}</td><td>{{ $trade->is_active ? 'Oui' : 'Non' }}</td><td class="p-3 text-right"><a class="text-gold-400" href="{{ route('admin.trades.edit', $trade) }}">Edit</a></td></tr>
@empty
<tr><td colspan="5" class="p-4 text-center text-ash-200">Aucun trade.</td></tr>
@endforelse
</tbody></table></div>
{{ $trades->links() }}
@endsection