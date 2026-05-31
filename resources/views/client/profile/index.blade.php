@extends('layouts.client')

@section('title', 'Profil')

@section('content')
<div class="mx-auto max-w-2xl space-y-8">
    <section>
        <h1 class="mb-6 text-2xl font-black text-ash-900">Mon Profil</h1>
        <form method="POST" action="{{ route('client.profile.update') }}" class="grid gap-6 rounded-2xl border border-gold-100 bg-white p-8 shadow-sm">
            @csrf 
            @method('PATCH')
            
            <div class="grid gap-2">
                <label class="text-sm font-bold uppercase tracking-wider text-ash-500">Nom complet</label>
                <input class="rounded-xl border border-ash-200 bg-white px-4 py-3 text-ash-900 focus:border-crimson-400 focus:ring-crimson-400 font-medium" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="grid gap-2">
                <label class="text-sm font-bold uppercase tracking-wider text-ash-500">Numéro de téléphone</label>
                <input class="rounded-xl border border-ash-200 bg-white px-4 py-3 text-ash-900 focus:border-crimson-400 focus:ring-crimson-400 font-medium" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Ex: +33 6 12 34 56 78">
            </div>

            <div class="grid gap-2">
                <label class="text-sm font-bold uppercase tracking-wider text-ash-500">Pays de résidence</label>
                <input class="rounded-xl border border-ash-200 bg-white px-4 py-3 text-ash-900 focus:border-crimson-400 focus:ring-crimson-400 font-medium" name="country" value="{{ old('country', $user->country) }}" placeholder="Ex: France">
            </div>

            <button class="mt-2 rounded-xl bg-crimson-400 px-6 py-4 font-black text-white transition-all hover:bg-crimson-600 hover:shadow-lg active:scale-95">
                Enregistrer les modifications
            </button>
        </form>
    </section>

    <section>
        <h2 class="mb-6 text-xl font-black text-ash-900">Code Bonus</h2>
        <form method="POST" action="{{ route('client.bonus-codes.redeem') }}" class="grid gap-6 rounded-2xl border border-gold-100 bg-white p-8 shadow-sm">
            @csrf
            <div class="grid gap-2">
                <label class="text-sm font-bold uppercase tracking-wider text-ash-500">Entrez votre code</label>
                <input class="rounded-xl border border-ash-200 bg-white px-4 py-3 text-ash-900 focus:border-ember-400 focus:ring-ember-400 font-bold tracking-widest placeholder:tracking-normal" name="code" placeholder="Ex: PHOENIX2024">
            </div>
            
            <button class="rounded-xl bg-ember-400 px-6 py-4 font-black text-white transition-all hover:bg-ember-600 hover:shadow-lg active:scale-95">
                Activer le code bonus
            </button>
        </form>
    </section>
</div>
@endsection
