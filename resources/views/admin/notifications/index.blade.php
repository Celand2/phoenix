@extends('layouts.admin')

@section('title', 'Notifications')

@section('content')
<div class="mb-10">
    <h1 class="text-2xl font-black text-ash-900 mb-6">Envoyer une Notification</h1>
    <form method="POST" action="{{ route('admin.notifications.send') }}" class="grid gap-4 rounded-2xl border border-gold-100 bg-white p-8 shadow-sm">
        @csrf
        <div class="grid gap-4 md:grid-cols-2">
            <div class="grid gap-2">
                <label class="text-xs font-bold uppercase tracking-widest text-ash-400">Destinataire</label>
                <select class="rounded-xl border border-ash-200 bg-white px-4 py-3 text-ash-900 focus:border-crimson-400 focus:ring-crimson-400 font-medium" name="user_id">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>
            <div class="grid gap-2">
                <label class="text-xs font-bold uppercase tracking-widest text-ash-400">Type de notification</label>
                <input class="rounded-xl border border-ash-200 bg-white px-4 py-3 text-ash-900 focus:border-crimson-400 focus:ring-crimson-400" name="type" placeholder="Ex: admin_message" value="admin_message">
            </div>
        </div>
        
        <div class="grid gap-2">
            <label class="text-xs font-bold uppercase tracking-widest text-ash-400">Titre</label>
            <input class="rounded-xl border border-ash-200 bg-white px-4 py-3 text-ash-900 focus:border-crimson-400 focus:ring-crimson-400 font-bold" name="title" placeholder="Objet du message">
        </div>

        <div class="grid gap-2">
            <label class="text-xs font-bold uppercase tracking-widest text-ash-400">Contenu du message</label>
            <textarea class="min-h-[120px] rounded-xl border border-ash-200 bg-white px-4 py-3 text-ash-900 focus:border-crimson-400 focus:ring-crimson-400" name="body" placeholder="Rédigez votre message ici..."></textarea>
        </div>

        <button class="mt-2 w-full rounded-xl bg-crimson-400 px-6 py-4 font-black text-white transition-all hover:bg-crimson-600 hover:shadow-lg active:scale-95 md:w-max md:px-12">
            Envoyer la notification
        </button>
    </form>
</div>

<h2 class="text-xl font-black text-ash-900 mb-6 tracking-tight">Historique des envois</h2>
<div class="overflow-hidden rounded-2xl border border-gold-100 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gold-50 text-xs font-bold uppercase tracking-wider text-ash-500">
                <tr>
                    <th class="p-4">Destinataire</th>
                    <th class="p-4">Titre</th>
                    <th class="p-4 text-center">Type</th>
                    <th class="p-4 text-center">Date d'envoi</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gold-100 text-ash-900">
                @forelse($notifications as $notification)
                <tr class="transition-colors hover:bg-gold-50/50">
                    <td class="p-4 font-bold text-ash-900">{{ $notification->user?->name }}</td>
                    <td class="p-4 text-ash-600">{{ $notification->title }}</td>
                    <td class="p-4 text-center">
                        <span class="inline-flex rounded-md bg-ash-100 px-2 py-1 text-[10px] font-black uppercase tracking-widest text-ash-600">
                            {{ $notification->type }}
                        </span>
                    </td>
                    <td class="p-4 text-center text-ash-400">{{ $notification->created_at?->format('d/m/Y H:i') }}</td>
                    <td class="p-4 text-right">
                        <form action="{{ route('admin.notifications.destroy', $notification) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette notification ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-bold text-crimson-400 hover:text-crimson-600 hover:underline transition-colors">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-12 text-center text-ash-400 italic">
                        Aucune notification envoyée.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-8">
    {{ $notifications->links() }}
</div>
@endsection
