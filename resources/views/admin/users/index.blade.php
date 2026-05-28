@extends('layouts.admin')

@section('title', 'Utilisateurs')

@section('content')
<div class="overflow-x-auto rounded-lg border border-ash-600 bg-ash-800"><table class="w-full text-left text-sm"><thead class="bg-ash-900 text-ash-200"><tr><th class="p-3">Nom</th><th>Email</th><th>Investi</th><th>Gains</th><th>Statut</th><th></th></tr></thead><tbody>
@foreach ($users as $user)
<tr class="border-t border-ash-600"><td class="p-3">{{ $user->name }}</td><td>{{ $user->email }}</td><td class="text-crimson-400">{{ $user->balance_invested }}</td><td class="text-gold-400">{{ $user->balance_gains }}</td><td>{{ $user->status }}</td><td><a class="text-gold-400" href="{{ route('admin.users.show', $user) }}">Voir</a></td></tr>
@endforeach
</tbody></table></div>{{ $users->links() }}
@endsection
