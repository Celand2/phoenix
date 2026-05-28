@extends('layouts.admin')

@section('title', $message->subject)

@section('content')
<article class="rounded-lg border border-ash-600 bg-ash-800 p-5"><p class="text-sm text-ash-200">{{ $message->user?->name }} - {{ $message->from }}</p><p class="mt-4 whitespace-pre-line">{{ $message->body }}</p></article>
@endsection
