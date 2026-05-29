@extends('layouts.client')
@section('title', 'Depot')
@section('content')
<form method="POST" action="{{ route('client.deposits.store') }}" enctype="multipart/form-data" class="grid max-w-2xl gap-4 rounded-lg border border-ash-600 bg-ash-800 p-5" data-money-converter>
@csrf
<input type="hidden" name="user_trade_id" value="{{ $userTrade->id }}">
<p class="text-lg font-bold">{{ $userTrade->trade?->name }} <span class="text-gold-400">{{ \App\Support\Money::formatUsd($userTrade->amount) }}</span></p>
<select class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="payment_method_id" required data-money-method>
@foreach($paymentMethods as $method)
@php($snapshot = \App\Support\Money::snapshotFor($method))
<option value="{{ $method->id }}" data-rate="{{ $snapshot['rate'] }}" data-currency="{{ $snapshot['currency'] }}" data-details="{{ $method->details }}">{{ $method->name }} - {{ $snapshot['currency'] }}</option>
@endforeach
</select>
<div class="rounded-lg border border-gold-600 bg-ash-900 px-3 py-2 text-sm text-gold-100" data-method-details>
    <p class="font-semibold text-gold-400">Details du paiement</p>
    <p class="mt-1 whitespace-pre-line" data-details-content>{{ $paymentMethods->first()?->details }}</p>
</div>
<p class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2 text-sm text-ash-100" data-money-preview data-amount-usd="{{ $userTrade->amount }}">
    Equivalent: {{ \App\Support\Money::formatUsd($userTrade->amount) }}
</p>
<input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="proof" type="file" accept="image/*" data-proof-input>
<img class="hidden max-h-64 rounded-lg border border-ash-600 object-contain" alt="Proof preview" data-proof-preview>
<button class="rounded-lg bg-crimson-400 px-4 py-2 font-semibold text-white">Envoyer le depot</button>
</form>
@endsection