@extends('layouts.admin')
@section('title', 'Depots')
@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-ash-900">Validation des Dépôts</h1>
    <p class="text-ash-500">Confirmez les transactions des clients après vérification des preuves.</p>
</div>

<div class="overflow-hidden rounded-2xl border border-gold-100 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gold-50 text-xs font-bold uppercase tracking-wider text-ash-500">
                <tr>
                    <th class="p-4">Client</th>
                    <th class="p-4">Produit</th>
                    <th class="p-4">Méthode</th>
                    <th class="p-4">Montant</th>
                    <th class="p-4">Statut</th>
                    <th class="p-4">Preuve</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gold-100 text-ash-900">
                @forelse ($deposits as $deposit)
                <tr class="transition-colors hover:bg-gold-50/50">
                    <td class="p-4">
                        <p class="font-bold text-ash-900">{{ $deposit->user?->name }}</p>
                        <p class="text-[10px] text-ash-400">{{ $deposit->user?->email }}</p>
                    </td>
                    <td class="p-4 font-medium text-ash-600">{{ $deposit->userTrade?->trade?->name ?? 'Dépôt direct' }}</td>
                    <td class="p-4 text-ash-500">{{ $deposit->paymentMethod?->name }}</td>
                    <td class="p-4 font-black text-crimson-600">
                        {{ \App\Support\Money::formatSnapshot($deposit->amount_usd, $deposit->amount_local, $deposit->currency_local) }}
                    </td>
                    <td class="p-4">
                        @php
                            $badgeClass = match($deposit->status) {
                                'approved' => 'bg-gold-100 text-gold-800',
                                'rejected' => 'bg-crimson-100 text-crimson-800',
                                default => 'bg-ash-100 text-ash-600',
                            };
                        @endphp
                        <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest {{ $badgeClass }}">
                            {{ ucfirst($deposit->status) }}
                        </span>
                    </td>
                    <td class="p-4">
                        @if($deposit->proof)
                            <button type="button" class="font-bold text-gold-600 hover:text-gold-800 hover:underline" data-proof-trigger="{{ asset('storage/'.$deposit->proof) }}">
                                Voir reçu
                            </button>
                        @else
                            <span class="text-xs text-ash-300 italic">Aucune</span>
                        @endif
                    </td>
                    <td class="p-4">
                        <div class="flex items-center justify-end gap-2">
                            @if($deposit->status==='pending')
                                <form method="POST" action="{{ route('admin.deposits.approve', $deposit) }}">
                                    @csrf 
                                    @method('PATCH')
                                    <button class="rounded-lg bg-gold-400 px-3 py-1.5 text-[10px] font-black uppercase tracking-widest text-gold-900 transition-all hover:bg-gold-500 hover:shadow-md active:scale-95">
                                        Approuver
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.deposits.reject', $deposit) }}">
                                    @csrf 
                                    @method('PATCH')
                                    <button class="rounded-lg bg-crimson-50 px-3 py-1.5 text-[10px] font-black uppercase tracking-widest text-crimson-700 transition-all hover:bg-crimson-100 active:scale-95">
                                        Rejeter
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('admin.deposits.destroy', $deposit) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce depot ?')">
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
                        Aucun dépôt en attente ou traité.
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

<div data-proof-modal class="fixed inset-0 z-50 hidden items-center justify-center bg-ash-900/80 p-4 backdrop-blur-sm">
    <div class="relative max-h-[90vh] max-w-3xl overflow-hidden rounded-2xl border border-gold-100 bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b border-gold-50 bg-gold-50/50 p-4">
            <h3 class="font-bold text-ash-900">Preuve de paiement</h3>
            <button type="button" data-proof-close class="rounded-lg bg-crimson-100 px-3 py-1 text-xs font-black uppercase tracking-widest text-crimson-700 hover:bg-crimson-200 transition-colors">Fermer</button>
        </div>
        <div class="overflow-auto p-4">
            <img data-proof-image class="max-h-[70vh] rounded-xl object-contain shadow-inner" alt="Proof">
        </div>
    </div>
</div>
@endsection