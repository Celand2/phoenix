@extends('layouts.admin')

@section('title', 'Taux de change')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-black text-ash-900">Taux de Change</h1>
    <p class="text-ash-500">Configurez les taux de conversion entre les différentes devises.</p>
    
    <form method="POST" action="{{ route('admin.exchange-rates.store') }}" class="mt-6 grid gap-4 rounded-2xl border border-gold-100 bg-white p-6 shadow-sm md:grid-cols-5 items-end">
        @csrf
        <div class="grid gap-1">
            <label class="text-[10px] font-bold uppercase tracking-widest text-ash-400 px-1">De (ex: USD)</label>
            <input class="rounded-xl border border-ash-200 bg-white px-4 py-2 text-sm text-ash-900 focus:border-crimson-400 focus:ring-crimson-400 font-bold" name="currency_from" placeholder="USD" required>
        </div>
        <div class="grid gap-1">
            <label class="text-[10px] font-bold uppercase tracking-widest text-ash-400 px-1">Vers (ex: EUR)</label>
            <input class="rounded-xl border border-ash-200 bg-white px-4 py-2 text-sm text-ash-900 focus:border-crimson-400 focus:ring-crimson-400 font-bold" name="currency_to" placeholder="EUR" required>
        </div>
        <div class="grid gap-1">
            <label class="text-[10px] font-bold uppercase tracking-widest text-ash-400 px-1">Taux actuel</label>
            <input class="rounded-xl border border-ash-200 bg-white px-4 py-2 text-sm text-ash-900 focus:border-crimson-400 focus:ring-crimson-400 font-bold" name="rate" type="number" step="0.000001" placeholder="1.000000" required>
        </div>
        <div class="flex items-center justify-center py-2">
            <label class="flex items-center gap-2 cursor-pointer group">
                <input type="checkbox" name="is_active" value="1" checked class="rounded border-ash-300 text-gold-600 focus:ring-gold-400">
                <span class="text-xs font-bold text-ash-500 group-hover:text-ash-900 transition-colors uppercase tracking-widest">Actif</span>
            </label>
        </div>
        <button class="rounded-xl bg-crimson-400 px-4 py-3 text-xs font-black uppercase tracking-widest text-white shadow-lg shadow-crimson-100 hover:bg-crimson-600 transition-all active:scale-95">
            Enregistrer
        </button>
    </form>
</div>

<div class="overflow-hidden rounded-2xl border border-gold-100 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gold-50 text-xs font-bold uppercase tracking-wider text-ash-500">
                <tr>
                    <th class="p-4">Devise source</th>
                    <th class="p-4">Devise cible</th>
                    <th class="p-4 text-center">Taux de conversion</th>
                    <th class="p-4 text-right">Statut</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gold-100 text-ash-900 font-medium">
                @forelse($exchangeRates as $rate)
                <tr class="transition-colors hover:bg-gold-50/50">
                    <td class="p-4 font-black text-ash-900 uppercase tracking-widest">{{ $rate->currency_from }}</td>
                    <td class="p-4 font-black text-ash-900 uppercase tracking-widest">{{ $rate->currency_to }}</td>
                    <td class="p-4 text-center font-black text-gold-600 font-mono">{{ number_format($rate->rate, 6) }}</td>
                    <td class="p-4 text-right">
                        <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest {{ $rate->is_active ? 'bg-gold-100 text-gold-800' : 'bg-ash-100 text-ash-400' }}">
                            {{ $rate->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-12 text-center text-ash-400 italic">
                        Aucun taux de change enregistré.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-8">
    {{ $exchangeRates->links() }}
</div>
@endsection
