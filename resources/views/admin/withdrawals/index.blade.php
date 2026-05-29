@extends('layouts.admin')
@section('title', 'Retraits')
@section('content')
<div class="overflow-x-auto rounded-lg border border-ash-600 bg-ash-800"><table class="w-full min-w-[900px] text-left text-sm">
<thead class="bg-ash-900 text-ash-200"><tr><th class="p-3">Client</th><th>Methode</th><th>Demande</th><th>Frais</th><th>Recu</th><th>Statut</th><th>Actions</th></tr></thead><tbody>
@forelse ($withdrawals as $withdrawal)
<tr class="border-t border-ash-600"><td class="p-3">{{ $withdrawal->user?->name }}</td><td>{{ $withdrawal->paymentMethod?->name }}</td><td>{{ \App\Support\Money::formatSnapshot($withdrawal->amount_requested, $withdrawal->amount_requested_local, $withdrawal->currency_local) }}</td><td>{{ \App\Support\Money::formatSnapshot($withdrawal->fee, $withdrawal->fee_local, $withdrawal->currency_local) }}</td><td class="text-gold-400">{{ \App\Support\Money::formatSnapshot($withdrawal->amount_received, $withdrawal->amount_received_local, $withdrawal->currency_local) }}</td><td>{{ ucfirst($withdrawal->status) }}</td><td class="flex gap-2 py-2">@if($withdrawal->status==='pending')<form method="POST" action="{{ route('admin.withdrawals.approve', $withdrawal) }}">@csrf @method('PATCH')<button class="rounded-lg bg-gold-400 px-3 py-1 text-ash-900">Approuver</button></form><form method="POST" action="{{ route('admin.withdrawals.reject', $withdrawal) }}">@csrf @method('PATCH')<button class="rounded-lg bg-crimson-400 px-3 py-1 text-white">Rejeter</button></form>@endif</td></tr>
@empty
<tr><td colspan="7" class="p-4 text-center text-ash-200">Aucun retrait.</td></tr>
@endforelse
</tbody></table></div>{{ $withdrawals->links() }}
@endsection