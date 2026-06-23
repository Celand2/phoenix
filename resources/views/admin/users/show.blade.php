@extends('layouts.admin')
@section('title', $user->name)
@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-black text-ash-900">Détails de l'utilisateur : {{ $user->name }}</h1>
    <p class="text-ash-500 italic">{{ $user->email }}</p>
</div>

<div class="grid gap-8 lg:grid-cols-2">
    <!-- Gestion des Soldes -->
    <form method="POST" action="{{ route('admin.users.balance', $user) }}" class="flex flex-col gap-6 rounded-2xl border border-gold-100 bg-white p-8 shadow-sm">
        @csrf 
        @method('PATCH')
        <h2 class="text-lg font-black text-ash-900 flex items-center gap-2">
            <span class="size-2 rounded-full bg-gold-400"></span>
            Soldes du compte (USD)
        </h2>
        
        <div class="grid gap-4">
            <div class="grid gap-2">
                <label class="text-xs font-bold uppercase tracking-widest text-ash-400">Balance Investie</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-ash-300">$</span>
                    <input class="w-full rounded-xl border border-ash-200 bg-white pl-8 pr-4 py-3 text-ash-900 focus:border-crimson-400 focus:ring-crimson-400 font-bold" name="balance_invested" type="number" step="0.01" value="{{ $user->balance_invested }}">
                </div>
            </div>
            
            <div class="grid gap-2">
                <label class="text-xs font-bold uppercase tracking-widest text-ash-400">Balance Gains</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-ash-300">$</span>
                    <input class="w-full rounded-xl border border-ash-200 bg-white pl-8 pr-4 py-3 text-ash-900 focus:border-gold-400 focus:ring-gold-400 font-bold" name="balance_gains" type="number" step="0.01" value="{{ $user->balance_gains }}">
                </div>
            </div>
        </div>

        <button class="w-full rounded-xl bg-crimson-400 px-6 py-4 font-black text-white transition-all hover:bg-crimson-600 hover:shadow-lg active:scale-95">
            Mettre à jour les soldes
        </button>
    </form>

    <div class="flex flex-col gap-8">
        <!-- Modification du Mot de Passe -->
        <form method="POST" action="{{ route('admin.users.password', $user) }}" class="flex flex-col gap-6 rounded-2xl border border-gold-100 bg-white p-8 shadow-sm">
            @csrf 
            @method('PATCH')
            <h2 class="text-lg font-black text-ash-900 flex items-center gap-2">
                <span class="size-2 rounded-full bg-ash-900"></span>
                Sécurité du compte
            </h2>
            
            <div class="grid gap-4">
                <div class="grid gap-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-ash-400">Nouveau mot de passe</label>
                    <input class="w-full rounded-xl border border-ash-200 bg-white px-4 py-3 text-ash-900 focus:border-crimson-400 focus:ring-crimson-400" name="password" type="password" required>
                </div>
                <div class="grid gap-2">
                    <label class="text-xs font-bold uppercase tracking-widest text-ash-400">Confirmer le mot de passe</label>
                    <input class="w-full rounded-xl border border-ash-200 bg-white px-4 py-3 text-ash-900 focus:border-crimson-400 focus:ring-crimson-400" name="password_confirmation" type="password" required>
                </div>
            </div>

            <button class="w-full rounded-xl bg-ash-900 px-6 py-4 font-black text-white transition-all hover:bg-black active:scale-95">
                Changer le mot de passe
            </button>
        </form>

        <!-- Statut du Compte -->
        <form method="POST" action="{{ route('admin.users.status', $user) }}" class="flex flex-col gap-6 rounded-2xl border border-gold-100 bg-white p-8 shadow-sm">
            @csrf 
            @method('PATCH')
            <h2 class="text-lg font-black text-ash-900 flex items-center gap-2">
                <span class="size-2 rounded-full bg-crimson-400"></span>
                Statut du compte
            </h2>
            <select class="rounded-xl border border-ash-200 bg-white px-4 py-3 text-ash-900 focus:border-crimson-400 focus:ring-crimson-400 font-bold" name="status">
                <option @selected($user->status==='active') value="active">Actif</option>
                <option @selected($user->status==='inactive') value="inactive">Inactif</option>
                <option @selected($user->status==='suspended') value="suspended">Suspendu</option>
            </select>
            <button class="w-full rounded-xl bg-ash-900 px-6 py-4 font-black text-white transition-all hover:bg-black active:scale-95">
                Mettre à jour le statut
            </button>
        </form>

        <!-- Préférences monétaires -->
        <form method="POST" action="{{ route('admin.users.preferences', $user) }}" class="rounded-2xl border border-gold-100 bg-gold-50 p-8 shadow-sm">
            @csrf
            @method('PATCH')
            <h2 class="text-lg font-black text-ash-900 mb-4">Préférences monétaires</h2>
            <div class="space-y-4">
                <div class="grid gap-2">
                    <label class="text-sm font-bold uppercase tracking-wider text-ash-500">Mode de paiement préféré</label>
                    <select class="rounded-xl border border-ash-200 bg-white px-4 py-3 text-ash-900 focus:border-crimson-400 focus:ring-crimson-400" name="payment_method_id" required>
                        @foreach($paymentMethods as $method)
                            @php $snapshot = \App\Support\Money::snapshotFor($method); @endphp
                            <option value="{{ $method->id }}" @selected($method->id === $user->preferred_payment_method_id)>
                                {{ $method->name }} ({{ $snapshot['currency'] }})
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-ash-500">La devise et le taux sont définis automatiquement en fonction du moyen de paiement choisi.</p>
                </div>

                <div class="flex items-center justify-between border-b border-gold-100 pb-2">
                    <span class="text-sm font-medium text-ash-500 uppercase tracking-wider">Devise locale</span>
                    <span class="font-black text-gold-800">{{ $user->preferred_currency ?? 'USD (Défaut)' }}</span>
                </div>
                @if($user->preferred_rate)
                <div class="flex items-center justify-between border-b border-gold-100 pb-2">
                    <span class="text-sm font-medium text-ash-500 uppercase tracking-wider">Taux de change</span>
                    <span class="font-black text-gold-800">1 USD = {{ $user->preferred_rate }} {{ $user->preferred_currency }}</span>
                </div>
                @endif
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-ash-500 uppercase tracking-wider">Inscrit le</span>
                    <span class="font-bold text-ash-700">{{ $user->created_at?->format('d/m/Y') }}</span>
                </div>
                <button class="w-full rounded-xl bg-crimson-400 px-6 py-4 font-black text-white transition-all hover:bg-crimson-600 hover:shadow-lg active:scale-95">
                    Mettre à jour 
                </button>
            </div>
        </form>

        <!-- Suppression du Compte -->
        <div class="rounded-2xl border border-crimson-100 bg-crimson-50 p-8 shadow-sm">
            <h2 class="text-lg font-black text-crimson-800 mb-4 flex items-center gap-2">
                <span class="size-2 rounded-full bg-crimson-600"></span>
                Zone de danger
            </h2>
            <p class="text-sm text-crimson-700 mb-6">La suppression d'un compte est irreversible. Toutes les donnees associees seront perdues.</p>
            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Supprimer definitivement ce compte ?')">
                @csrf 
                @method('DELETE')
                <button class="w-full rounded-xl bg-crimson-600 px-6 py-4 font-black text-white transition-all hover:bg-crimson-700 hover:shadow-lg active:scale-95">
                    Supprimer le compte
                </button>
            </form>
        </div>
    </div>
</div>
@endsection