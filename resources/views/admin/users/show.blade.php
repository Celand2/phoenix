@extends('layouts.admin')

@section('title', $user->name)

@section('content')
<div class="grid gap-6 lg:grid-cols-2">
<form method="POST" action="{{ route('admin.users.balance', $user) }}" class="grid gap-4 rounded-lg border border-ash-600 bg-ash-800 p-4">@csrf @method('PATCH')<h2 class="font-semibold text-gold-400">Soldes</h2><input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="balance_invested" type="number" step="0.01" value="{{ $user->balance_invested }}"><input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="balance_gains" type="number" step="0.01" value="{{ $user->balance_gains }}"><button class="rounded-lg bg-crimson-400 px-4 py-2 font-semibold text-white">Sauver</button></form>
<form method="POST" action="{{ route('admin.users.status', $user) }}" class="grid gap-4 rounded-lg border border-ash-600 bg-ash-800 p-4">@csrf @method('PATCH')<h2 class="font-semibold text-gold-400">Statut</h2><select class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="status"><option @selected($user->status==='active') value="active">active</option><option @selected($user->status==='inactive') value="inactive">inactive</option><option @selected($user->status==='suspended') value="suspended">suspended</option></select><button class="rounded-lg bg-crimson-400 px-4 py-2 font-semibold text-white">Mettre a jour</button></form>
</div>
@endsection
