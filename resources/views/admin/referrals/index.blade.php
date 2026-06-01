@extends('layouts.admin')

@section('title', 'Parrainage')

@section('content')
<div class="overflow-x-auto rounded-lg border border-ash-200 bg-white shadow-sm"><table class="w-full text-left text-sm"><thead class="bg-ash-50 text-ash-600 border-b border-ash-200"><tr><th class="p-3">Referrer</th><th>Filleul</th><th>Niveau</th><th>Commission</th><th>Statut</th></tr></thead><tbody>
@foreach ($referrals as $referral)
<tr class="border-t border-ash-100 hover:bg-ash-50 transition-colors"><td class="p-3">{{ $referral->referrer?->name }}</td><td>{{ $referral->referred?->name }}</td><td>{{ $referral->level }}</td><td class="text-gold-600 font-medium">{{ $referral->commission_amount }}</td><td>{{ $referral->status }}</td></tr>
@endforeach
</tbody></table></div>{{ $referrals->links() }}
@endsection
