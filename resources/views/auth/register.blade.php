@extends('layouts.auth')

@section('title', 'Inscription')

@section('content')
<form method="POST" action="/register" class="grid gap-4">
    @csrf
    <input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="name" value="{{ old('name') }}" placeholder="Nom complet" required>
    <input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="email" type="email" value="{{ old('email') }}" placeholder="Email" required>
    <input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="phone" value="{{ old('phone') }}" placeholder="Telephone" required>
    <input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="country" value="{{ old('country') }}" placeholder="Pays" required>
    <input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="referrer_code" value="{{ old('referrer_code') }}" placeholder="Code de parrainage (facultatif)">
    <input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="password" type="password" placeholder="Mot de passe" required>
    <input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="password_confirmation" type="password" placeholder="Confirmation du mot de passe" required>
    <button class="rounded-lg bg-crimson-400 px-4 py-2 font-semibold text-white hover:bg-crimson-600">Creer le compte</button>
</form>
<p class="mt-4 text-center text-sm text-ash-200">
    Vous avez deja un compte ?
    <a class="font-semibold text-gold-400 hover:text-gold-600" href="/login">Connectez-vous</a>
</p>
@endsection
