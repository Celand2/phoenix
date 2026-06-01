@extends('layouts.admin')

@section('title', 'User Trades')

@section('content')
<div class="overflow-x-auto rounded-lg border border-ash-200 bg-white shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="bg-ash-50 text-ash-600 border-b border-ash-200"><tr><th class="p-3">Client</th><th>Trade</th><th>Categorie</th><th>Statut</th><th>Gain/j</th><th></th></tr></thead><tbody>
@foreach ($userTrades as $userTrade)
<tr class="border-t border-ash-100 hover:bg-ash-50 transition-colors"><td class="p-3">{{ $userTrade->user?->name }}</td><td>{{ $userTrade->trade?->name }}</td><td>{{ $userTrade->category?->name }}</td><td>{{ $userTrade->status }}</td><td class="text-gold-600 font-medium">{{ $userTrade->daily_gain }}</td><td><form method="POST" action="{{ route('admin.user-trades.expire', $userTrade) }}">@csrf @method('PATCH')<button class="text-crimson-600 font-medium hover:underline">Expirer</button></form></td></tr>
@endforeach
</tbody></table></div>{{ $userTrades->links() }}
@endsection
