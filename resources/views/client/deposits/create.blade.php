@extends('layouts.client')
@section('title', 'Depot')
@section('content')
<div class="mx-auto max-w-2xl">
    <h1 class="mb-6 text-2xl font-black text-ash-900">Finaliser mon investissement</h1>
    
    <form method="POST" action="{{ route('client.deposits.store') }}" enctype="multipart/form-data" class="grid gap-6 rounded-2xl border border-gold-100 bg-white p-8 shadow-sm" data-money-converter>
        @csrf
        <input type="hidden" name="trade_id" value="{{ $trade->id }}">
        
        <div class="flex items-center justify-between border-b border-gold-100 pb-4">
            <h2 class="text-xl font-bold text-ash-900">{{ $trade->name }}</h2>
            <span class="text-2xl font-black text-crimson-600">{{ \App\Support\Money::formatUsd($trade->amount) }}</span>
        </div>

        <div class="grid gap-2">
            <label class="text-sm font-bold uppercase tracking-wider text-ash-500">Méthode de paiement</label>
            <select class="rounded-xl border border-ash-200 bg-white px-4 py-3 text-ash-900 focus:border-crimson-400 focus:ring-crimson-400" name="payment_method_id" required data-money-method>
                @foreach($paymentMethods as $method)
                    @php
                        $snapshot = \App\Support\Money::snapshotFor($method);
                    @endphp
                    <option value="{{ $method->id }}" data-rate="{{ $snapshot['rate'] }}" data-currency="{{ $snapshot['currency'] }}" data-details="{{ $method->details }}">
                        {{ $method->name }} ({{ $snapshot['currency'] }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="rounded-xl border border-gold-200 bg-gold-50 p-4 text-sm shadow-inner" data-method-details>
            <p class="font-bold text-gold-800 underline decoration-gold-300 decoration-2 underline-offset-4">Détails du paiement</p>
            <p class="mt-3 whitespace-pre-line font-medium text-ash-700" data-details-content>{{ $paymentMethods->first()?->details }}</p>
        </div>

        <div class="rounded-xl border border-ash-100 bg-ash-50 p-4" data-money-preview data-amount-usd="{{ $trade->amount }}">
            <p class="text-xs font-bold uppercase tracking-widest text-ash-400">Montant à envoyer</p>
            <p class="mt-1 text-lg font-black text-ash-900">Equivalent: {{ \App\Support\Money::formatUsd($trade->amount) }}</p>
        </div>

        <div class="grid gap-2">
            <label class="text-sm font-bold uppercase tracking-wider text-ash-500">Preuve de paiement (Screenshot)</label>
            <div class="flex flex-col gap-4">
                <input class="block w-full text-sm text-ash-500 file:mr-4 file:rounded-full file:border-0 file:bg-crimson-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-crimson-700 hover:file:bg-crimson-100" name="proof" type="file" accept="image/*" required data-proof-input>
                <img class="hidden max-h-64 rounded-xl border border-gold-100 object-contain shadow-sm" alt="Proof preview" data-proof-preview>
            </div>
        </div>

        <button class="mt-4 rounded-xl bg-crimson-400 px-6 py-4 text-lg font-black text-white transition-all hover:bg-crimson-600 hover:shadow-xl active:scale-95">
            Confirmer l'envoi du dépôt
        </button>
    </form>
</div>
@endsection