@extends('layouts.admin')

@section('title', 'Nouvelle categorie')

@section('content')
<form method="POST" action="{{ route('admin.categories.store') }}" class="grid max-w-2xl gap-4">
    @csrf
    @include('admin.categories.form')
    <button class="rounded-lg bg-crimson-400 px-4 py-2 font-semibold text-white hover:bg-crimson-600">Creer</button>
</form>
@endsection
