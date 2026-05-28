<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Trade;
use Illuminate\Http\Request;

class TradeController extends Controller
{
    public function index()
    {
        return view('admin.trades.index', ['trades' => Trade::with('category')->orderBy('display_order')->paginate(20)]);
    }

    public function create()
    {
        return view('admin.trades.create', ['categories' => Category::orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        Trade::create($this->validated($request));

        return redirect()->route('admin.trades.index')->with('status', 'Trade cree.');
    }

    public function edit(Trade $trade)
    {
        return view('admin.trades.edit', ['trade' => $trade, 'categories' => Category::orderBy('name')->get()]);
    }

    public function update(Request $request, Trade $trade)
    {
        $trade->update($this->validated($request));

        return redirect()->route('admin.trades.index')->with('status', 'Trade mis a jour.');
    }

    public function destroy(Trade $trade)
    {
        $trade->delete();

        return back()->with('status', 'Trade supprime.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ]) + ['is_active' => false, 'display_order' => 0];
    }
}
