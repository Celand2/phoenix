<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\Withdrawal;
use App\Services\WithdrawalService;
use App\Support\Money;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
    public function index()
    {
        return view('client.withdrawals.index', [
            'withdrawals' => Withdrawal::with('paymentMethod')->where('user_id', Auth::id())->latest()->paginate(20),
            'paymentMethods' => PaymentMethod::with('exchangeRate')->active()->get(),
        ]);
    }

    public function store(Request $request, WithdrawalService $withdrawalService)
    {
        $data = $request->validate([
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'account_number' => ['required', 'string', 'max:255'],
            'account_name' => ['required', 'string', 'max:255'],
        ]);

        $user = Auth::user();
        $paymentMethod = PaymentMethod::with('exchangeRate')->active()->findOrFail($data['payment_method_id']);
        $snapshot = Money::snapshotFor($paymentMethod);

        if ($user->preferred_currency && $user->preferred_currency !== $snapshot['currency']) {
            return back()->withErrors(['payment_method_id' => 'Votre monnaie preferee est ' . $user->preferred_currency . '. Choisissez une methode compatible.']);
        }

        // Vérification du minimum de 0.25 USD
        $isFirstCurrencyChoice = ! $user->preferred_currency;
        $amountUsd = $isFirstCurrencyChoice ? (float)$data['amount'] : Money::toUsd((float)$data['amount'], $user->preferred_rate);

        if ($amountUsd < 0.25) {
            return back()->withErrors(['amount' => 'Le montant minimum de retrait est de 0.25 USD.']);
        }

        $ok = $withdrawalService->create($user, $paymentMethod, (float) $data['amount'], $data['account_number'], $data['account_name']);

        return $ok
            ? back()->with('status', 'Retrait demande.')
            : back()->withErrors(['amount' => 'Solde gains insuffisant.']);
    }
}
