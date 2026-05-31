@extends('layouts.client')

@section('title', 'Messages')

@section('content')
<div class="mb-10">
    <h1 class="mb-6 text-2xl font-black text-ash-900">Nouveau message</h1>
    <form method="POST" action="{{ route('client.messages.store') }}" class="grid gap-4 rounded-2xl border border-gold-100 bg-white p-6 shadow-sm">
        @csrf
        <div class="grid gap-2">
            <label class="text-sm font-bold uppercase tracking-wider text-ash-500">Sujet de votre demande</label>
            <input class="rounded-xl border border-ash-200 bg-white px-4 py-3 text-ash-900 focus:border-crimson-400 focus:ring-crimson-400" name="subject" placeholder="Ex: Problème avec mon dépôt">
        </div>
        <div class="grid gap-2">
            <label class="text-sm font-bold uppercase tracking-wider text-ash-500">Message</label>
            <textarea class="min-h-[120px] rounded-xl border border-ash-200 bg-white px-4 py-3 text-ash-900 focus:border-crimson-400 focus:ring-crimson-400" name="body" placeholder="Décrivez votre demande en détail..."></textarea>
        </div>
        <button class="w-full rounded-xl bg-crimson-400 px-6 py-4 font-black text-white transition-all hover:bg-crimson-600 hover:shadow-lg active:scale-95 md:w-max md:px-12">
            Envoyer à l'administration
        </button>
    </form>
</div>

<div class="grid gap-4">
    <h2 class="mb-2 text-xl font-black text-ash-900">Historique des échanges</h2>
    @forelse($messages as $message)
    <article class="rounded-2xl border border-gold-100 bg-white p-5 shadow-sm transition-colors hover:border-gold-200">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gold-50 pb-3">
            <h3 class="font-bold text-ash-900">{{ $message->subject }}</h3>
            <span class="text-xs font-bold uppercase tracking-widest text-ash-400">{{ $message->created_at?->diffForHumans() }}</span>
        </div>
        <p class="mt-4 whitespace-pre-line text-sm leading-relaxed text-ash-700">{{ $message->body }}</p>
        <div class="mt-4 flex items-center gap-2">
            <div class="size-2 rounded-full {{ $message->admin_id ? 'bg-gold-400' : 'bg-crimson-400' }}"></div>
            <span class="text-xs font-bold text-ash-500">{{ $message->admin_id ? 'Réponse de l\'Admin' : 'Moi' }}</span>
        </div>
    </article>
    @empty
    <div class="rounded-2xl border border-ash-100 bg-ash-50 p-12 text-center text-ash-400">
        Aucun message dans votre historique.
    </div>
    @endforelse
</div>
<div class="mt-8">
    {{ $messages->links() }}
</div>
@endsection
