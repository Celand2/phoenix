@extends('layouts.admin')
@section('title', 'Depots')
@section('content')
<div class="overflow-x-auto rounded-lg border border-ash-600 bg-ash-800"><table class="w-full min-w-[800px] text-left text-sm">
<thead class="bg-ash-900 text-ash-200"><tr><th class="p-3">Client</th><th>Trade</th><th>Methode</th><th>Montant</th><th>Statut</th><th><td>@if($deposit->proof)<button type="button" class="text-gold-400" data-proof-trigger="{{ asset('storage/'.$deposit->proof) }}">Voir</button>@endif</td><th>Actions</th></tr></thead><tbody>
@forelse ($deposits as $deposit)
<tr class="border-t border-ash-600"><td class="p-3">{{ $deposit->user?->name }}</td><td>{{ $deposit->userTrade?->trade?->name }}</td><td>{{ $deposit->paymentMethod?->name }}</td><td>{{ \App\Support\Money::formatSnapshot($deposit->amount_usd, $deposit->amount_local, $deposit->currency_local) }}</td><td>{{ ucfirst($deposit->status) }}</td><td>@if($deposit->proof)<a class="text-gold-400" href="{{ asset('storage/'.$deposit->proof) }}">Voir</a>@endif</td><td class="flex gap-2 py-2">@if($deposit->status==='pending')<form method="POST" action="{{ route('admin.deposits.approve', $deposit) }}">@csrf @method('PATCH')<button class="rounded-lg bg-gold-400 px-3 py-1 text-ash-900">Approuver</button></form><form method="POST" action="{{ route('admin.deposits.reject', $deposit) }}">@csrf @method('PATCH')<button class="rounded-lg bg-crimson-400 px-3 py-1 text-white">Rejeter</button></form>@endif</td></tr>
@empty
<tr><td colspan="7" class="p-4 text-center text-ash-200">Aucun depot.</td></tr>
@endforelse
</tbody></table></div>{{ $deposits->links() }}

<div data-proof-modal class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 p-4">
    <div class="relative max-h-[90vh] max-w-3xl overflow-auto rounded-lg border border-ash-600 bg-ash-800 p-2">
        <button type="button" data-proof-close class="absolute right-2 top-2 rounded-lg bg-crimson-400 px-3 py-1 text-white">Fermer</button>
        <img data-proof-image class="max-h-[85vh] rounded-lg object-contain" alt="Proof">
    </div>
</div>
@endsection