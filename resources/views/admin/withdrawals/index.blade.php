@extends('layouts.admin')

@section('title', 'Retraits')

@section('content')
<div class="overflow-x-auto rounded-lg border border-ash-600 bg-ash-800"><table class="w-full text-left text-sm">
<thead class="bg-ash-900 text-ash-200"><tr><th class="p-3">Client</th><th>Methode</th><th>Demande</th><th>Frais</th><th>Recu</th><th>Statut</th><th>Actions</th></tr></thead><tbody>
@foreach ($withdrawals as $withdrawal)
<tr class="border-t border-ash-600"><td class="p-3">{{ $withdrawal->user?->name }}</td><td>{{ $withdrawal->paymentMethod?->name }}</td><td>{{ $withdrawal->amount_requested }}</td><td>{{ $withdrawal->fee }}</td><td class="text-gold-400">{{ $withdrawal->amount_received }}</td><td>{{ $withdrawal->status }}</td><td class="flex gap-2 py-2"><form method="POST" action="{{ route('admin.withdrawals.approve', $withdrawal) }}">@csrf @method('PATCH')<button class="rounded-lg bg-gold-400 px-3 py-1 text-ash-900">Approuver</button></form><form method="POST" action="{{ route('admin.withdrawals.reject', $withdrawal) }}">@csrf @method('PATCH')<button class="rounded-lg bg-crimson-400 px-3 py-1 text-white">Rejeter</button></form></td></tr>
@endforeach
</tbody></table></div>{{ $withdrawals->links() }}
@endsection
