@extends('layouts.admin')

@section('title', 'Nouvelle methode')

@section('content')
<form method="POST" action="{{ route('admin.payment-methods.store') }}" class="grid max-w-2xl gap-4">@csrf @include('admin.payment-methods.form')<button class="rounded-lg bg-crimson-400 px-4 py-2 font-semibold text-white">Creer</button></form>
@endsection
