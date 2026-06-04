@extends('layouts.admin')
@section('title', 'Retraits')
@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-ash-900">Validation des Retraits</h1>
    <p class="text-ash-500">Gérez les demandes de retrait des clients et appliquez les frais correspondants.</p>
</div>

<div class="overflow-hidden rounded-2xl border border-gold-100 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gold-50 text-xs font-bold uppercase tracking-wider text-ash-500">
                <tr>
                    <th class="p-4">Client</th>
                    <th class="p-4">Méthode</th>
                    <th class="p-4">Demande</th>
                    <th class="p-4">Frais</th>
                    <th class="p-4">Net Reçu</th>
                    <th class="p-4">Statut</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gold-100 text-ash-900">
                @forelse ($withdrawals as $withdrawal)
                <tr class="transition-colors hover:bg-gold-50/50">
                    <td class="p-4">
                        <p class="font-bold text-ash-900">{{ $withdrawal->user?->name }}</p>
                        <p class="text-[10px] text-ash-400">{{ $withdrawal->user?->email }}</p>
                    </td>
                    <td class="p-4 text-ash-500 font-medium">{{ $withdrawal->paymentMethod?->name }}</td>
                    <td class="p-4 font-medium text-ash-700">
                        {{ \App\Support\Money::formatSnapshot($withdrawal->amount_requested, $withdrawal->amount_requested_local, $withdrawal->currency_local) }}
                    </td>
                    <td class="p-4 font-medium text-crimson-600/70">
                        -{{ \App\Support\Money::formatSnapshot($withdrawal->fee, $withdrawal->fee_local, $withdrawal->currency_local) }}
                    </td>
                    <td class="p-4 font-black text-gold-600">
                        {{ \App\Support\Money::formatSnapshot($withdrawal->amount_received, $withdrawal->amount_received_local, $withdrawal->currency_local) }}
                    </td>
                    <td class="p-4">
                        @php
                            $badgeClass = match($withdrawal->status) {
                                'approved', 'completed' => 'bg-gold-100 text-gold-800',
                                'rejected', 'cancelled' => 'bg-crimson-100 text-crimson-800',
                                default => 'bg-ash-100 text-ash-600',
                            };
                        @endphp
                        <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest {{ $badgeClass }}">
                            {{ ucfirst($withdrawal->status) }}
                        </span>
                    </td>
                    <td class="p-4">
                        <div class="flex items-center justify-end gap-2">
                            @if($withdrawal->status==='pending')
                                <form method="POST" action="{{ route('admin.withdrawals.approve', $withdrawal) }}">
                                    @csrf 
                                    @method('PATCH')
                                    <button class="rounded-lg bg-gold-400 px-3 py-1.5 text-[10px] font-black uppercase tracking-widest text-gold-900 transition-all hover:bg-gold-500 hover:shadow-md active:scale-95">
                                        Approuver
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.withdrawals.reject', $withdrawal) }}">
                                    @csrf 
                                    @method('PATCH')
                                    <button class="rounded-lg bg-crimson-50 px-3 py-1.5 text-[10px] font-black uppercase tracking-widest text-crimson-700 transition-all hover:bg-crimson-100 active:scale-95">
                                        Rejeter
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.withdrawals.destroy', $withdrawal) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce retrait ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-lg bg-ash-50 px-3 py-1.5 text-[10px] font-black uppercase tracking-widest text-ash-700 transition-all hover:bg-ash-100 active:scale-95">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-12 text-center text-ash-400">
                        Aucune demande de retrait à traiter.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8">
    {{ $withdrawals->links() }}
</div>
@endsection