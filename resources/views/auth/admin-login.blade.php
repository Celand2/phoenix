@extends('layouts.auth')

@section('title', 'Admin Login')

@section('content')
<form method="POST" action="{{ route('admin.login.store') }}" class="grid gap-6">
    @csrf
    <div class="grid gap-2">
        <label class="text-xs font-bold uppercase tracking-widest text-ash-400">Identifiant Administrateur</label>
        <input class="rounded-xl border border-ash-200 bg-white px-4 py-3 text-ash-900 focus:border-crimson-400 focus:ring-crimson-400" name="email" type="email" placeholder="admin@phenix.com" value="{{ old('email') }}" required autofocus>
    </div>

    <div class="grid gap-2">
        <label class="text-xs font-bold uppercase tracking-widest text-ash-400">Mot de passe</label>
        <input class="rounded-xl border border-ash-200 bg-white px-4 py-3 text-ash-900 focus:border-crimson-400 focus:ring-crimson-400" name="password" type="password" placeholder="••••••••" required>
    </div>

    <div class="flex items-center">
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="remember" value="1" class="rounded border-ash-300 text-crimson-600 focus:ring-crimson-400">
            <span class="text-sm text-ash-500 font-medium">Maintenir la session</span>
        </label>
    </div>

    <button class="w-full rounded-xl bg-ash-900 py-4 font-black text-white transition-all hover:bg-black hover:shadow-lg active:scale-95">
        Accéder au Panel Admin
    </button>
</form>
@endsection
