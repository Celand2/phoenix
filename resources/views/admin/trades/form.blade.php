<label class="text-sm text-ash-200">Categorie
<select class="mt-1 w-full rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="category_id" required>
@foreach ($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id', $trade->category_id ?? '') == $category->id)>{{ $category->name }}</option>@endforeach
</select></label>
<label class="text-sm text-ash-200">Nom
<input class="mt-1 w-full rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="name" placeholder="Nom" value="{{ old('name', $trade->name ?? '') }}" required></label>
<label class="text-sm text-ash-200">Montant (USD)
<input class="mt-1 w-full rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="amount" type="number" step="0.01" min="0" placeholder="Montant en USD" value="{{ old('amount', $trade->amount ?? '') }}" required></label>
<label class="text-sm text-ash-200">Ordre d'affichage
<input class="mt-1 w-full rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="display_order" type="number" placeholder="Ordre" value="{{ old('display_order', $trade->display_order ?? 0) }}"></label>
<label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $trade->is_active ?? true))> Actif</label>