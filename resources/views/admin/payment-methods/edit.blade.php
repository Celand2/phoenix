@extends('layouts.admin')

@section('title', 'Edit methode')

@section('content')
<form method="POST" action="{{ route('admin.payment-methods.update', $paymentMethod) }}" class="grid max-w-2xl gap-4">@csrf @method('PATCH') @include('admin.payment-methods.form')<button class="rounded-lg bg-crimson-400 px-4 py-2 font-semibold text-white">Sauver</button></form>
@endsection
