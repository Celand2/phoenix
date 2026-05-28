<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExchangeRate;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        return view('admin.payment-methods.index', ['paymentMethods' => PaymentMethod::with('exchangeRate')->paginate(20)]);
    }

    public function create()
    {
        return view('admin.payment-methods.create', ['exchangeRates' => ExchangeRate::orderBy('currency_from')->get()]);
    }

    public function store(Request $request)
    {
        PaymentMethod::create($this->validated($request));

        return redirect()->route('admin.payment-methods.index')->with('status', 'Methode creee.');
    }

    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.payment-methods.edit', ['paymentMethod' => $paymentMethod, 'exchangeRates' => ExchangeRate::orderBy('currency_from')->get()]);
    }

    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $paymentMethod->update($this->validated($request));

        return redirect()->route('admin.payment-methods.index')->with('status', 'Methode mise a jour.');
    }

    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();

        return back()->with('status', 'Methode supprimee.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'details' => ['required', 'string'],
            'logo' => ['nullable', 'string', 'max:255'],
            'exchange_rate_id' => ['nullable', 'exists:exchange_rates,id'],
            'is_active' => ['sometimes', 'boolean'],
        ]) + ['is_active' => false];
    }
}
