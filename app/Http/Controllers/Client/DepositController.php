<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\PaymentMethod;
use App\Models\UserTrade;
use App\Support\Money;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    public function index()
    {
        return view('client.deposits.index', ['deposits' => Deposit::with(['userTrade.trade', 'paymentMethod'])->where('user_id', Auth::id())->latest()->paginate(20)]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_trade_id' => ['required', 'exists:user_trades,id'],
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
            'proof' => ['nullable', 'image', 'max:4096'],
        ]);

        $user = Auth::user();
        $paymentMethod = PaymentMethod::with('exchangeRate')->active()->findOrFail($data['payment_method_id']);
        $snapshot = Money::snapshotFor($paymentMethod);

        if ($user->preferred_currency && $user->preferred_currency !== $snapshot['currency']) {
            return back()->withErrors(['payment_method_id' => 'Votre monnaie preferee est ' . $user->preferred_currency . '. Choisissez une methode compatible.']);
        }

        if (! $user->preferred_currency) {
            $user->update([
                'preferred_payment_method_id' => $paymentMethod->id,
                'preferred_currency' => $snapshot['currency'],
                'preferred_rate' => $snapshot['rate'],
            ]);
        }

        $userTrade = UserTrade::where('user_id', $user->id)->findOrFail($data['user_trade_id']);
        $proof = $request->file('proof')?->store('deposit-proofs', 'public');
        $amountUsd = (float) $userTrade->amount;

        Deposit::create([
            'user_id' => $user->id,
            'user_trade_id' => $userTrade->id,
            'payment_method_id' => $paymentMethod->id,
            'amount_usd' => $amountUsd,
            'amount_local' => Money::toLocal($amountUsd, $snapshot['rate']),
            'currency_local' => $snapshot['currency'],
            'exchange_rate' => $snapshot['rate'],
            'proof' => $proof,
            'status' => 'pending',
        ]);

        return redirect()->route('client.deposits.index')->with('status', 'Depot envoye.');
    }
}
