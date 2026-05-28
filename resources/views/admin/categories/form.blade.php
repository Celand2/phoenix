<input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="name" placeholder="Nom" value="{{ old('name', $category->name ?? '') }}" required>
<textarea class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="description" placeholder="Description">{{ old('description', $category->description ?? '') }}</textarea>
<input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="daily_profit_percent" type="number" step="0.01" placeholder="Profit journalier %" value="{{ old('daily_profit_percent', $category->daily_profit_percent ?? '') }}" required>
<input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="duration_days" type="number" placeholder="Duree en jours" value="{{ old('duration_days', $category->duration_days ?? '') }}" required>
<input class="rounded-lg border border-ash-600 bg-ash-900 px-3 py-2" name="display_order" type="number" placeholder="Ordre" value="{{ old('display_order', $category->display_order ?? 0) }}">
<label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active ?? true))> Active</label>
