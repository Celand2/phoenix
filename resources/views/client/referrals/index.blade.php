@extends('layouts.client')

@section('title', 'Parrainage')

@section('content')
<div class="mb-8 grid gap-6 md:grid-cols-2">
    <div class="rounded-2xl border border-gold-100 bg-white p-6 shadow-sm">
        <p class="text-xs font-bold uppercase tracking-widest text-ash-400">Lien de Parrainage</p>
        <div class="mt-2 flex items-center justify-between gap-4">
            <p class="font-black text-crimson-600 text-sm ">{{ url('/register?ref=' . auth()->user()->referral_code) }}</p>
            <button onclick="copyToClipboard('{{ url('/register?ref=' . auth()->user()->referral_code) }}', this)" class="shrink-0 rounded-lg bg-gold-50 px-4 py-2 text-xs font-bold text-gold-200 hover:bg-gold-100 transition-colors">Copier</button>
        </div>
    </div>

    <div class="rounded-2xl border border-gold-100 bg-white p-6 shadow-sm">
        <p class="text-xs font-bold uppercase tracking-widest text-ash-400">Total Commissions</p>
        <p class="mt-2 text-3xl font-black text-gold-600">
            {{ \App\Support\Money::formatForUser($totalCommissions, auth()->user()) }}
        </p>
    </div>
</div>

<div class="mb-8 overflow-hidden rounded-2xl border border-gold-100 bg-white shadow-sm">
    <div class="border-b border-gold-100 px-6 py-4">
        <h2 class="text-lg font-black text-ash-900">Filleuls inscrits</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gold-50 text-xs font-bold uppercase tracking-wider text-ash-500">
                <tr>
                    <th class="p-4">Filleul</th>
                    <th class="p-4">Email</th>
                    <th class="p-4 text-right">Inscription</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gold-100 text-ash-900">
                @forelse($referredUsers as $referredUser)
                <tr class="transition-colors hover:bg-gold-50/50">
                    <td class="p-4 font-medium">{{ $referredUser->name }}</td>
                    <td class="p-4 text-ash-500">{{ $referredUser->email }}</td>
                    <td class="p-4 text-right text-ash-500">{{ $referredUser->created_at?->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="p-12 text-center text-ash-400">
                        Aucun filleul inscrit pour le moment.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="overflow-hidden rounded-2xl border border-gold-100 bg-white shadow-sm">
    <div class="border-b border-gold-100 px-6 py-4">
        <h2 class="text-lg font-black text-ash-900">Commissions de parrainage</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gold-50 text-xs font-bold uppercase tracking-wider text-ash-500">
                <tr>
                    <th class="p-4">Filleul</th>
                    <th class="p-4">Niveau</th>
                    <th class="p-4">Commission</th>
                    <th class="p-4 text-right">Statut</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gold-100 text-ash-900">
                @forelse($referrals as $referral)
                <tr class="transition-colors hover:bg-gold-50/50">
                    <td class="p-4 font-medium">{{ $referral->referred?->name }}</td>
                    <td class="p-4">
                        <span class="inline-flex items-center rounded-md bg-ash-100 px-2 py-1 text-xs font-medium text-ash-600">
                            Niveau {{ $referral->level }}
                        </span>
                    </td>
                    <td class="p-4 font-bold text-gold-600">{{ \App\Support\Money::formatForUser($referral->commission_amount, auth()->user()) }}</td>
                    <td class="p-4 text-right">
                        <span class="inline-flex rounded-full bg-gold-100 px-3 py-1 text-xs font-bold text-gold-800">
                            {{ ucfirst($referral->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-12 text-center text-ash-400">
                        Aucun parrainage enregistré pour le moment.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-8">
    {{ $referrals->links() }}
</div>

<script>
function copyToClipboard(text, btn) {
    navigator.clipboard.writeText(text).then(() => {
        const originalText = btn.innerText;
        btn.innerText = 'Copié !';
        btn.classList.replace('bg-gold-50', 'bg-green-50');
        btn.classList.replace('text-gold-700', 'text-green-700');
        setTimeout(() => {
            btn.innerText = originalText;
            btn.classList.replace('bg-green-50', 'bg-gold-50');
            btn.classList.replace('text-green-700', 'text-gold-700');
        }, 2000);
    }).catch(err => {
        alert('Erreur lors de la copie');
    });
}
</script>
@endsection
