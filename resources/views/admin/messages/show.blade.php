@extends('layouts.admin')

@section('title', $message->subject)

@section('content')
<article class="rounded-2xl border border-ash-200 bg-white p-6 shadow-sm shadow-gold-100">
    <div class="flex items-center justify-between border-b border-ash-100 pb-4 mb-4">
        <div>
            <h2 class="text-xs font-bold uppercase tracking-widest text-ash-400">Expéditeur</h2>
            <p class="text-sm font-black text-ash-900">{{ $message->user?->name ?? 'Visiteur' }} <span class="text-ash-400 font-medium">({{ $message->from }})</span></p>
        </div>
        <div class="text-right">
            <h2 class="text-xs font-bold uppercase tracking-widest text-ash-400">Date</h2>
            <p class="text-sm font-bold text-ash-600">{{ $message->created_at->format('d/m/Y H:i') }}</p>
        </div>
    </div>
    <div class="mt-4">
        <h2 class="text-xs font-bold uppercase tracking-widest text-ash-400 mb-2">Message</h2>
        <p class="whitespace-pre-line text-ash-700 leading-relaxed font-medium">{{ $message->body }}</p>
    </div>
</article>
@endsection
