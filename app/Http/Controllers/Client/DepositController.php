<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\PaymentMethod;
use App\Models\UserTrade;
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

        $userTrade = UserTrade::where('user_id', Auth::id())->findOrFail($data['user_trade_id']);
        $proof = $request->file('proof')?->store('deposit-proofs', 'public');

        Deposit::create([
            'user_id' => Auth::id(),
            'user_trade_id' => $userTrade->id,
            'payment_method_id' => $data['payment_method_id'],
            'proof' => $proof,
            'status' => 'pending',
        ]);

        return redirect()->route('client.deposits.index')->with('status', 'Depot envoye.');
    }
}
