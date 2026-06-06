@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<form method="POST" action="/login" class="grid gap-6">
    @csrf
    <div class="grid gap-2">
        <label class="text-sm font-bold uppercase tracking-wider text-ash-500">Adresse Email</label>
        <input class="rounded-xl border border-ash-200 bg-white px-2 py-1.5 text-ash-900 focus:border-crimson-400 focus:ring-crimson-400" name="email" type="email" placeholder="nom@exemple.com" value="{{ old('email') }}" required autofocus>
    </div>

    <div class="grid gap-2">
        <label class="text-sm font-bold uppercase tracking-wider text-ash-500">Mot de passe</label>
        <input class="rounded-xl border border-ash-200 bg-white px-2 py-1.5 text-ash-900 focus:border-crimson-400 focus:ring-crimson-400" name="password" type="password" placeholder="••••••••" required>
    </div>

    <div class="flex items-center justify-between">
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="remember" class="rounded border-ash-300 text-crimson-600 focus:ring-crimson-400">
            <span class="text-sm text-ash-500 font-medium">Se souvenir de moi</span>
        </label>
    </div>

    <button class="w-full rounded-xl bg-crimson-400 py-1.5 font-black text-white transition-all hover:bg-crimson-600 hover:shadow-lg active:scale-95">
        Se connecter
    </button>

    <p class="mt-4 text-center text-sm text-ash-500">
        Vous n'avez pas de compte ? 
        <a href="{{ route('register') }}" class="font-bold text-crimson-600 hover:underline">Inscrivez-vous</a>
    </p>
</form>
@endsection
