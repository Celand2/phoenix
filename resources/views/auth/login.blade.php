@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<form method="POST" action="/login" class="grid gap-4">
    @csrf
    <input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="email" type="email" placeholder="Email" value="{{ old('email') }}" required>
    <input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="password" type="password" placeholder="Password" required>
    <button class="rounded-lg bg-crimson-400 px-4 py-2 font-semibold text-white hover:bg-crimson-600">Connexion</button>
</form>
@endsection
