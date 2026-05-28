@extends('layouts.client')

@section('title', 'Depot')

@section('content')
<form method="POST" action="{{ route('client.deposits.store') }}" enctype="multipart/form-data" class="grid max-w-2xl gap-4 rounded-lg border border-ash-600 bg-ash-800 p-5">
@csrf
<input type="hidden" name="user_trade_id" value="{{ $userTrade->id }}">
<p class="text-lg font-bold">{{ $userTrade->trade?->name }} <span class="text-gold-400">{{ $userTrade->amount }}</span></p>
<select class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="payment_method_id" required>@foreach($paymentMethods as $method)<option value="{{ $method->id }}">{{ $method->name }}</option>@endforeach</select>
<input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="proof" type="file" accept="image/*" data-proof-input>
<img class="hidden max-h-64 rounded-lg border border-ash-600 object-contain" alt="Proof preview" data-proof-preview>
<button class="rounded-lg bg-crimson-400 px-4 py-2 font-semibold text-white">Envoyer le depot</button>
</form>
@endsection
