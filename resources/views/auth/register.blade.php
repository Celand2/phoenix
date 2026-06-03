@extends('layouts.auth')

@section('title', 'Inscription')

@section('content')
<form method="POST" action="/register" class="grid gap-4">
    @csrf
    <div class="grid gap-1">
        <label class="text-[10px] font-bold uppercase tracking-widest text-ash-400 px-1">Nom complet</label>
        <input class="rounded-xl border border-ash-200 bg-white px-4 py-2.5 text-sm text-ash-900 focus:border-crimson-400 focus:ring-crimson-400" name="name" value="{{ old('name') }}" placeholder="Ex: Jean Dupont" required autofocus>
    </div>

    <div class="grid gap-1">
        <label class="text-[10px] font-bold uppercase tracking-widest text-ash-400 px-1">Adresse Email</label>
        <input class="rounded-xl border border-ash-200 bg-white px-4 py-2.5 text-sm text-ash-900 focus:border-crimson-400 focus:ring-crimson-400" name="email" type="email" value="{{ old('email') }}" placeholder="jean@exemple.com" required>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div class="grid gap-1">
            <label class="text-[10px] font-bold uppercase tracking-widest text-ash-400 px-1">Téléphone</label>
            <input class="rounded-xl border border-ash-200 bg-white px-4 py-2.5 text-sm text-ash-900 focus:border-crimson-400 focus:ring-crimson-400" name="phone" value="{{ old('phone') }}" placeholder="+33..." required>
        </div>
        <div class="grid gap-1">
            <label class="text-[10px] font-bold uppercase tracking-widest text-ash-400 px-1">Pays</label>
            <input class="rounded-xl border border-ash-200 bg-white px-4 py-2.5 text-sm text-ash-900 focus:border-crimson-400 focus:ring-crimson-400" name="country" value="{{ old('country') }}" placeholder="France" required>
        </div>
    </div>

    <div class="grid gap-1">
        <label class="text-[10px] font-bold uppercase tracking-widest text-ash-400 px-1 text-gold-600">Code de parrainage (facultatif)</label>
        <input class="rounded-xl border border-gold-100 bg-white px-4 py-2.5 text-sm text-ash-900 focus:border-gold-400 focus:ring-gold-400" name="referrer_code" value="{{ old('referrer_code') }}" placeholder="Ex: phenix123">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 border-t border-gold-50 pt-3">
        <div class="grid gap-1">
            <label class="text-[10px] font-bold uppercase tracking-widest text-ash-400 px-1">Mot de passe</label>
            <input class="rounded-xl border border-ash-200 bg-white px-4 py-2.5 text-sm text-ash-900 focus:border-crimson-400 focus:ring-crimson-400" name="password" type="password" placeholder="••••••••" required>
        </div>
        <div class="grid gap-1">
            <label class="text-[10px] font-bold uppercase tracking-widest text-ash-400 px-1">Confirmation</label>
            <input class="rounded-xl border border-ash-200 bg-white px-4 py-2.5 text-sm text-ash-900 focus:border-crimson-400 focus:ring-crimson-400" name="password_confirmation" type="password" placeholder="••••••••" required>
        </div>
    </div>

    <button class="mt-4 w-full rounded-xl bg-crimson-400 py-4 font-black text-white transition-all hover:bg-crimson-600 hover:shadow-lg active:scale-95">
        Créer mon compte
    </button>
</form>

<p class="mt-6 text-center text-sm text-ash-500 font-medium">
    Vous avez déjà un compte ?
    <a class="font-bold text-crimson-600 hover:underline" href="/login">Connectez-vous</a>
</p>
@endsection
