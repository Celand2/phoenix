@extends('layouts.client')

@section('title', 'Depots')

@section('content')
<div class="overflow-x-auto rounded-lg border border-ash-600 bg-ash-800"><table class="w-full text-left text-sm"><thead class="bg-ash-900 text-ash-200"><tr><th class="p-3">Trade</th><th>Methode</th><th>Statut</th><th>Date</th></tr></thead><tbody>
@foreach($deposits as $deposit)<tr class="border-t border-ash-600"><td class="p-3">{{ $deposit->userTrade?->trade?->name }}</td><td>{{ $deposit->paymentMethod?->name }}</td><td>{{ $deposit->status }}</td><td>{{ $deposit->created_at?->format('d/m/Y') }}</td></tr>@endforeach
</tbody></table></div>{{ $deposits->links() }}
@endsection
