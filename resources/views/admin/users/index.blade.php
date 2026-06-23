@extends('layouts.admin')

@section('title', 'Utilisateurs')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-ash-900">Gestion des Utilisateurs</h1>
    <p class="text-ash-500">Consultez et gérez les comptes des membres de la plateforme.</p>
</div>

<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center">
        <label for="search" class="sr-only">Recherche utilisateur</label>
        <input id="search" name="search" type="search" value="{{ request('search') }}" placeholder="Recherche par ID, nom ou email" class="min-w-0 rounded-2xl border border-gold-100 bg-gold-50 px-4 py-3 text-sm text-ash-900 shadow-sm focus:border-crimson-400 focus:outline-none focus:ring-2 focus:ring-crimson-100" />
        <button type="submit" class="rounded-2xl bg-crimson-500 px-4 py-3 text-sm font-black uppercase tracking-widest text-white transition hover:bg-crimson-600">Rechercher</button>
        @if(request('search'))
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-ash-100 bg-white px-4 py-3 text-sm font-semibold text-ash-600 hover:bg-ash-50">Effacer</a>
        @endif
    </form>
    <p class="text-sm text-ash-500">Recherche rapide par ID, nom ou email.</p>
</div>

<div class="overflow-hidden rounded-2xl border border-gold-100 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gold-50 text-xs font-bold uppercase tracking-wider text-ash-500">
                <tr>
                    <th class="p-4">Utilisateur</th>
                    <th class="p-4">Investi (USD)</th>
                    <th class="p-4">Gains (USD)</th>
                    <th class="p-4">Statut</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gold-100 text-ash-900">
                @foreach ($users as $user)
                <tr class="transition-colors hover:bg-gold-50/50">
                    <td class="p-4">
                        <div class="flex flex-col">
                            <span class="font-bold text-ash-900">{{ $user->name }}</span>
                            <span class="text-xs text-ash-400">{{ $user->email }}</span>
                        </div>
                    </td>
                    <td class="p-4 font-black text-crimson-600">{{ number_format($user->balance_invested, 2) }}</td>
                    <td class="p-4 font-black text-gold-600">{{ number_format($user->balance_gains, 2) }}</td>
                    <td class="p-4">
                        @php
                            $statusClass = $user->status === 'active' ? 'bg-gold-100 text-gold-800' : 'bg-ash-100 text-ash-400';
                        @endphp
                        <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest {{ $statusClass }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </td>
                    <td class="p-4 text-right">
                        <a class="font-bold text-gold-600 hover:text-gold-800 hover:underline" href="{{ route('admin.users.show', $user) }}">
                            Détails
                        </a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-bold text-crimson-400 hover:text-crimson-600 hover:underline ml-2">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8">
    {{ $users->links() }}
</div>
@endsection
