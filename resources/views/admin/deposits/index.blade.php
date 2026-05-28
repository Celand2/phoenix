@extends('layouts.admin')

@section('title', 'Depots')

@section('content')
<div class="overflow-x-auto rounded-lg border border-ash-600 bg-ash-800"><table class="w-full text-left text-sm">
<thead class="bg-ash-900 text-ash-200"><tr><th class="p-3">Client</th><th>Trade</th><th>Methode</th><th>Statut</th><th>Proof</th><th>Actions</th></tr></thead><tbody>
@foreach ($deposits as $deposit)
<tr class="border-t border-ash-600"><td class="p-3">{{ $deposit->user?->name }}</td><td>{{ $deposit->userTrade?->trade?->name }}</td><td>{{ $deposit->paymentMethod?->name }}</td><td>{{ $deposit->status }}</td><td>@if($deposit->proof)<a class="text-gold-400" href="{{ asset('storage/'.$deposit->proof) }}">Voir</a>@endif</td><td class="flex gap-2 py-2"><form method="POST" action="{{ route('admin.deposits.approve', $deposit) }}">@csrf @method('PATCH')<button class="rounded-lg bg-gold-400 px-3 py-1 text-ash-900">Approuver</button></form><form method="POST" action="{{ route('admin.deposits.reject', $deposit) }}">@csrf @method('PATCH')<button class="rounded-lg bg-crimson-400 px-3 py-1 text-white">Rejeter</button></form></td></tr>
@endforeach
</tbody></table></div>{{ $deposits->links() }}
@endsection
