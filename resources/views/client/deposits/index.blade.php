@extends('layouts.client')

@section('title', 'Depots')

@section('content')
<div class="mb-6 flex items-center justify-between gap-4">
    <h1 class="text-2xl font-black text-ash-900">Mes Dépôts</h1>
    <a href="{{ route('client.deposits.store') }}" class="rounded-xl bg-crimson-400 px-6 py-3 font-bold text-white transition-all hover:bg-crimson-600 hover:shadow-lg active:scale-95">
        Nouveau dépôt
    </a>
</div>

<div class="overflow-hidden rounded-2xl border border-gold-100 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gold-50 text-xs font-bold uppercase tracking-wider text-ash-500">
                <tr>
                    <th class="p-4">Trade / Libellé</th>
                    <th class="p-4">Montant</th>
                    <th class="p-4">Méthode</th>
                    <th class="p-4">Statut</th>
                    <th class="p-4 text-right">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gold-100 text-ash-900">
                @forelse($deposits as $deposit)
                <tr class="transition-colors hover:bg-gold-50/50">
                    <td class="p-4 font-medium">{{ $deposit->userTrade?->trade?->name ?? 'Dépôt direct' }}</td>
                    <td class="p-4 font-bold text-crimson-600">
                        {{ \App\Support\Money::formatSnapshot($deposit->amount_usd ?? $deposit->userTrade?->amount, $deposit->amount_local, $deposit->currency_local) }}
                    </td>
                    <td class="p-4 text-ash-500">{{ $deposit->paymentMethod?->name }}</td>
                    <td class="p-4">
                        @php
                            $badgeClass = match($deposit->status) {
                                'approved', 'completed' => 'bg-gold-100 text-gold-800',
                                'rejected', 'cancelled' => 'bg-crimson-100 text-crimson-800',
                                default => 'bg-ash-100 text-ash-600',
                            };
                        @endphp
                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-bold {{ $badgeClass }}">
                            {{ ucfirst($deposit->status) }}
                        </span>
                    </td>
                    <td class="p-4 text-right text-ash-400">{{ $deposit->created_at?->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-12 text-center text-ash-400">
                        <p>Aucun dépôt enregistré pour le moment.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-8">
    {{ $deposits->links() }}
</div>
@endsection
