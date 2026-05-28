@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
<div class="mb-4"><a class="rounded-lg bg-crimson-400 px-4 py-2 font-semibold text-white hover:bg-crimson-600" href="{{ route('admin.categories.create') }}">Nouvelle categorie</a></div>
<div class="overflow-x-auto rounded-lg border border-ash-600 bg-ash-800">
<table class="w-full text-left text-sm">
    <thead class="bg-ash-900 text-ash-200"><tr><th class="p-3">Nom</th><th>Profit</th><th>Duree</th><th>Actif</th><th></th></tr></thead>
    <tbody>
    @foreach ($categories as $category)
        <tr class="border-t border-ash-600"><td class="p-3">{{ $category->name }}</td><td>{{ $category->daily_profit_percent }}%</td><td>{{ $category->duration_days }}j</td><td>{{ $category->is_active ? 'Oui' : 'Non' }}</td><td><a class="text-gold-400" href="{{ route('admin.categories.edit', $category) }}">Edit</a></td></tr>
    @endforeach
    </tbody>
</table>
</div>
{{ $categories->links() }}
@endsection
