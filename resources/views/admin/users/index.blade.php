@extends('layouts.admin')

@section('title', 'Utilisateurs')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-ash-900">Gestion des Utilisateurs</h1>
    <p class="text-ash-500">Consultez et gérez les comptes des membres de la plateforme.</p>
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
