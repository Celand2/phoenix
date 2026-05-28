@extends('layouts.client')

@section('title', 'Profil')

@section('content')
<form method="POST" action="{{ route('client.profile.update') }}" class="grid max-w-2xl gap-4 rounded-lg border border-ash-600 bg-ash-800 p-5">@csrf @method('PATCH')
<input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="name" value="{{ old('name', $user->name) }}" required>
<input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Telephone">
<input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="country" value="{{ old('country', $user->country) }}" placeholder="Pays">
<button class="rounded-lg bg-crimson-400 px-4 py-2 font-semibold text-white">Sauver</button>
</form>
<form method="POST" action="{{ route('client.bonus-codes.redeem') }}" class="mt-6 grid max-w-2xl gap-4 rounded-lg border border-ash-600 bg-ash-800 p-5">@csrf
<input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="code" placeholder="Code bonus">
<button class="rounded-lg bg-ember-400 px-4 py-2 font-semibold text-white hover:bg-ember-600">Utiliser le code</button>
</form>
@endsection
