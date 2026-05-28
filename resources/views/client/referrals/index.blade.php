@extends('layouts.client')

@section('title', 'Parrainage')

@section('content')
<div class="mb-4 rounded-lg border border-ash-600 bg-ash-800 p-4">
    <p class="text-sm text-ash-200">Code de parrainage</p>
    <p class="text-xl font-bold text-gold-400">{{ auth()->user()->referral_code }}</p>
</div>
<div class="overflow-x-auto rounded-lg border border-ash-600 bg-ash-800"><table class="w-full text-left text-sm"><thead class="bg-ash-900 text-ash-200"><tr><th class="p-3">Filleul</th><th>Niveau</th><th>Commission</th><th>Statut</th></tr></thead><tbody>@foreach($referrals as $referral)<tr class="border-t border-ash-600"><td class="p-3">{{ $referral->referred?->name }}</td><td>{{ $referral->level }}</td><td class="text-gold-400">{{ $referral->commission_amount }}</td><td>{{ $referral->status }}</td></tr>@endforeach</tbody></table></div>{{ $referrals->links() }}
@endsection
