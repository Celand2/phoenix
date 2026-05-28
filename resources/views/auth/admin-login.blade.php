@extends('layouts.auth')

@section('title', 'Admin Login')

@section('content')
<form method="POST" action="{{ route('admin.login.store') }}" class="grid gap-4">
    @csrf
    <input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="email" type="email" placeholder="Email" value="{{ old('email') }}" required>
    <input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="password" type="password" placeholder="Password" required>
    <label class="flex items-center gap-2 text-sm text-ash-100"><input type="checkbox" name="remember" value="1"> Remember</label>
    <button class="rounded-lg bg-crimson-400 px-4 py-2 font-semibold text-white hover:bg-crimson-600">Connexion</button>
</form>
@endsection
