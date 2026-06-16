<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\PaymentMethod;
use App\Models\UserTrade;
use App\Support\Money;
use App\Services\AdminNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    public function index()
    {
        return view('client.deposits.index', ['deposits' => Deposit::with(['userTrade.trade', 'paymentMethod'])->where('user_id', Auth::id())->latest()->paginate(20)]);
    }

    public function store(Request $request, AdminNotificationService $adminNotifications)
    {
        $data = $request->validate([
            'trade_id' => ['required', 'exists:trades,id'],
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
            'proof' => ['required', 'image', 'max:4096'],
        ]);

        $user = Auth::user();

        // Check for existing pending or active trade
        $exists = UserTrade::where('user_id', $user->id)
            ->where('trade_id', $data['trade_id'])
            ->whereIn('status', ['pending', 'active'])
            ->exists();

        if ($exists) {
            return redirect()->route('client.categories.index')->withErrors(['trade' => 'Vous avez deja ce trade actif ou en attente.']);
        }

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

        $trade = \App\Models\Trade::findOrFail($data['trade_id']);
        
        // Create the UserTrade as pending now that proof is submitted
        $userTrade = UserTrade::create([
            'user_id' => $user->id,
            'trade_id' => $trade->id,
            'category_id' => $trade->category_id,
            'amount' => $trade->amount,
            'daily_gain' => $trade->dailyGain(),
            'status' => 'pending',
        ]);

        $proof = $request->file('proof')->store('deposit-proofs', 'public');
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

        $adminNotifications->notifyAdmins(
            'Nouveau Depot en attente',
            "L'utilisateur {$user->name} a soumis un depot de " . Money::formatUsd($amountUsd) . " pour le trade {$trade->name}. Preuve jointe.",
            'new_deposit'
        );

        return redirect()->route('client.deposits.index')->with('status', 'Depot envoye.');
    }
}
