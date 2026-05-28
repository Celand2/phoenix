<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;

class ExchangeRateController extends Controller
{
    public function index()
    {
        return view('admin.exchange-rates.index', ['exchangeRates' => ExchangeRate::latest()->paginate(20)]);
    }

    public function store(Request $request)
    {
        ExchangeRate::create($this->validated($request));

        return back()->with('status', 'Taux cree.');
    }

    public function update(Request $request, ExchangeRate $exchangeRate)
    {
        $exchangeRate->update($this->validated($request));

        return back()->with('status', 'Taux mis a jour.');
    }

    public function destroy(ExchangeRate $exchangeRate)
    {
        $exchangeRate->delete();

        return back()->with('status', 'Taux supprime.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'currency_from' => ['required', 'string', 'max:10'],
            'currency_to' => ['required', 'string', 'max:10'],
            'rate' => ['required', 'numeric', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ]) + ['is_active' => false];
    }
}
