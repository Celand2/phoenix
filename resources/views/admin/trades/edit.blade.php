@extends('layouts.admin')

@section('title', 'Edit trade')

@section('content')
<div class="max-w-2xl">
    <form method="POST" action="{{ route('admin.trades.update', $trade) }}" id="updateForm" class="grid gap-4">
        @csrf
        @method('PATCH')
        @include('admin.trades.form')
    </form>

    <div class="mt-6 flex items-center gap-4">
        <button form="updateForm" class="rounded-lg bg-crimson-400 px-6 py-2 font-semibold text-white hover:bg-crimson-600 transition-colors">
            Sauver les modifications
        </button>
        <form action="{{ route('admin.trades.destroy', $trade) }}" method="POST" onsubmit="return confirm('Supprimer ce trade ?')" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="rounded-lg border border-crimson-100 bg-white px-6 py-2 font-semibold text-crimson-600 hover:bg-crimson-50 transition-colors">
                Supprimer
            </button>
        </form>
    </div>
</div>
@endsection
