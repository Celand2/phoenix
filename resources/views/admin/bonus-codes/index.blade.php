@extends('layouts.admin')

@section('title', 'Codes bonus')

@section('content')
<div class="mb-6 flex items-center justify-between gap-4">
    <h1 class="text-2xl font-black text-ash-900">Codes Bonus</h1>
    <a href="{{ route('admin.bonus-codes.create') }}" class="rounded-xl bg-crimson-400 px-6 py-3 font-bold text-white transition-all hover:bg-crimson-600 hover:shadow-lg">
        + Générer un code
    </a>
</div>

<div class="overflow-hidden rounded-2xl border border-gold-100 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gold-50 text-xs font-bold uppercase tracking-wider text-ash-500">
                <tr>
                    <th class="p-4">Code promo</th>
                    <th class="p-4">Montant (USD)</th>
                    <th class="p-4">Utilisations</th>
                    <th class="p-4">Statut</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gold-100 text-ash-900">
                @forelse ($bonusCodes as $bonusCode)
                <tr class="transition-colors hover:bg-gold-50/50">
                    <td class="p-4 font-black tracking-widest text-ash-900 uppercase">{{ $bonusCode->code }}</td>
                    <td class="p-4 font-black text-gold-600">{{ number_format($bonusCode->amount, 2) }}</td>
                    <td class="p-4">
                        <span class="text-ash-500">{{ $bonusCode->used_count }}</span>
                        <span class="text-ash-300 mx-1">/</span>
                        <span class="font-medium text-ash-700">{{ $bonusCode->max_uses }}</span>
                    </td>
                    <td class="p-4">
                        @php
                            $statusClass = $bonusCode->is_active ? 'bg-gold-100 text-gold-800' : 'bg-ash-100 text-ash-400';
                        @endphp
                        <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest {{ $statusClass }}">
                            {{ $bonusCode->status }}
                        </span>
                    </td>
                    <td class="p-4 text-right">
                        <form method="POST" action="{{ route('admin.bonus-codes.destroy', $bonusCode) }}" onsubmit="return confirm('Supprimer ce code ?')">
                            @csrf 
                            @method('DELETE')
                            <button class="font-bold text-crimson-600 hover:text-crimson-800 hover:underline transition-colors">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-12 text-center text-ash-400 italic">
                        Aucun code bonus disponible.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-8">
    {{ $bonusCodes->links() }}
</div>
@endsection
