@extends('layouts.admin')

@section('title', 'User Trades')

@section('content')
<div class="overflow-x-auto rounded-lg border border-ash-600 bg-ash-800"><table class="w-full text-left text-sm">
<thead class="bg-ash-900 text-ash-200"><tr><th class="p-3">Client</th><th>Trade</th><th>Categorie</th><th>Statut</th><th>Gain/j</th><th></th></tr></thead><tbody>
@foreach ($userTrades as $userTrade)
<tr class="border-t border-ash-600"><td class="p-3">{{ $userTrade->user?->name }}</td><td>{{ $userTrade->trade?->name }}</td><td>{{ $userTrade->category?->name }}</td><td>{{ $userTrade->status }}</td><td class="text-gold-400">{{ $userTrade->daily_gain }}</td><td><form method="POST" action="{{ route('admin.user-trades.expire', $userTrade) }}">@csrf @method('PATCH')<button class="text-crimson-200">Expirer</button></form></td></tr>
@endforeach
</tbody></table></div>{{ $userTrades->links() }}
@endsection
