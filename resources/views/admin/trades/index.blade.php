@extends('layouts.admin')

@section('title', 'Trades')

@section('content')
<div class="mb-4"><a class="rounded-lg bg-crimson-400 px-4 py-2 font-semibold text-white hover:bg-crimson-600" href="{{ route('admin.trades.create') }}">Nouveau trade</a></div>
<div class="overflow-x-auto rounded-lg border border-ash-600 bg-ash-800">
<table class="w-full text-left text-sm"><thead class="bg-ash-900 text-ash-200"><tr><th class="p-3">Nom</th><th>Categorie</th><th>Montant</th><th>Actif</th><th></th></tr></thead><tbody>
@foreach ($trades as $trade)
<tr class="border-t border-ash-600"><td class="p-3">{{ $trade->name }}</td><td>{{ $trade->category?->name }}</td><td class="text-gold-400">{{ $trade->amount }}</td><td>{{ $trade->is_active ? 'Oui' : 'Non' }}</td><td><a class="text-gold-400" href="{{ route('admin.trades.edit', $trade) }}">Edit</a></td></tr>
@endforeach
</tbody></table></div>
{{ $trades->links() }}
@endsection
