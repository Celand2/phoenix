@extends('layouts.admin')

@section('title', 'Codes bonus')

@section('content')
<div class="mb-4"><a class="rounded-lg bg-crimson-400 px-4 py-2 font-semibold text-white" href="{{ route('admin.bonus-codes.create') }}">Nouveau code</a></div>
<div class="overflow-x-auto rounded-lg border border-ash-600 bg-ash-800"><table class="w-full text-left text-sm"><thead class="bg-ash-900 text-ash-200"><tr><th class="p-3">Code</th><th>Montant</th><th>Utilisations</th><th>Statut</th><th></th></tr></thead><tbody>
@foreach ($bonusCodes as $bonusCode)
<tr class="border-t border-ash-600"><td class="p-3">{{ $bonusCode->code }}</td><td class="text-gold-400">{{ $bonusCode->amount }}</td><td>{{ $bonusCode->used_count }}/{{ $bonusCode->max_uses }}</td><td>{{ $bonusCode->status }}</td><td><form method="POST" action="{{ route('admin.bonus-codes.destroy', $bonusCode) }}">@csrf @method('DELETE')<button class="text-crimson-200">Supprimer</button></form></td></tr>
@endforeach
</tbody></table></div>{{ $bonusCodes->links() }}
@endsection
