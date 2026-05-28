@extends('layouts.admin')

@section('title', 'Nouveau code bonus')

@section('content')
<form method="POST" action="{{ route('admin.bonus-codes.store') }}" class="grid max-w-2xl gap-4">
@csrf
<input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="code" placeholder="Code" required>
<input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="amount" type="number" step="0.01" placeholder="Montant" required>
<input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="max_uses" type="number" placeholder="Max utilisations" required>
<select class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="status"><option value="active">active</option><option value="inactive">inactive</option></select>
<input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="expires_at" type="datetime-local">
<button class="rounded-lg bg-crimson-400 px-4 py-2 font-semibold text-white">Creer</button>
</form>
@endsection
