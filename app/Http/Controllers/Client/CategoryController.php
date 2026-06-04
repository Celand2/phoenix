<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return view('client.categories.index', [
            'categories' => Category::query()
                ->withCount(['trades as active_trades_count' => fn ($query) => $query->where('is_active', true)])
                ->active()
                ->paginate(12),
        ]);
    }

    public function show(Category $category)
    {
        abort_unless($category->is_active, 404);

        return view('client.categories.show', [
            'category' => $category,
            'trades' => $category->trades()
                ->with('category')
                ->active()
                ->paginate(20),
        ]);
    }
}
