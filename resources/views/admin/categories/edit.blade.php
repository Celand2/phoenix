@extends('layouts.admin')

@section('title', 'Edit categorie')

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.categories.update', $category) }}" id="updateForm" class="grid gap-4">
        @csrf
        @method('PATCH')
        @include('admin.categories.form')
    </form>

    <div class="mt-6 flex items-center gap-4">
        <button form="updateForm" class="rounded-lg bg-crimson-400 px-6 py-2 font-semibold text-white hover:bg-crimson-600 transition-colors">
            Sauver les modifications
        </button>
        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Supprimer cette categorie ?')" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="rounded-lg border border-crimson-100 bg-white px-6 py-2 font-semibold text-crimson-600 hover:bg-crimson-50 transition-colors">
                Supprimer
            </button>
        </form>
    </div>
</div>
@endsection
