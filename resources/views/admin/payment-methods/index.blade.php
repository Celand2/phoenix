@extends('layouts.admin')

@section('title', 'Methodes de paiement')

@section('content')
<div class="mb-6 flex items-center justify-between gap-4">
    <h1 class="text-2xl font-black text-ash-900">Méthodes de Paiement</h1>
    <a href="{{ route('admin.payment-methods.create') }}" class="rounded-xl bg-crimson-400 px-6 py-3 font-bold text-white transition-all hover:bg-crimson-600 hover:shadow-lg">
        + Ajouter une méthode
    </a>
</div>

<div class="overflow-hidden rounded-2xl border border-gold-100 bg-white shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gold-50 text-xs font-bold uppercase tracking-wider text-ash-500">
                <tr>
                    <th class="p-4">Nom de la passerelle</th>
                    <th class="p-4 text-center">Statut</th>
                    <th class="p-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gold-100 text-ash-900">
                @forelse ($paymentMethods as $paymentMethod)
                <tr class="transition-colors hover:bg-gold-50/50">
                    <td class="p-4 font-bold text-ash-900">{{ $paymentMethod->name }}</td>
                    <td class="p-4 text-center">
                        <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest {{ $paymentMethod->is_active ? 'bg-gold-100 text-gold-800' : 'bg-ash-100 text-ash-400' }}">
                            {{ $paymentMethod->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="p-4 text-right">
                        <a class="font-bold text-gold-600 hover:text-gold-800 hover:underline transition-colors" href="{{ route('admin.payment-methods.edit', $paymentMethod) }}">
                            Modifier
                        </a>
                        <form action="{{ route('admin.payment-methods.destroy', $paymentMethod) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette methode ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-bold text-crimson-400 hover:text-crimson-600 hover:underline transition-colors ml-2">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="p-12 text-center text-ash-400 italic">
                        Aucune méthode de paiement configurée.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-8">
    {{ $paymentMethods->links() }}
</div>
@endsection
