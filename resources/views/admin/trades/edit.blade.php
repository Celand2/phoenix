@extends('layouts.admin')

@section('title', 'Edit trade')

@section('content')
<form method="POST" action="{{ route('admin.trades.update', $trade) }}" class="grid max-w-2xl gap-4">@csrf @method('PATCH') @include('admin.trades.form')<button class="rounded-lg bg-crimson-400 px-4 py-2 font-semibold text-white hover:bg-crimson-600">Sauver</button></form>
@endsection
