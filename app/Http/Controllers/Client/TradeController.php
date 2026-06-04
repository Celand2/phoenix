<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\Trade;
use App\Models\UserTrade;
use Illuminate\Support\Facades\Auth;

class TradeController extends Controller
{
    public function index()
    {
        return redirect()->route('client.categories.index');
    }

    public function buy(Trade $trade)
    {
        $exists = UserTrade::where('user_id', Auth::id())
            ->where('trade_id', $trade->id)
            ->whereIn('status', ['pending', 'active'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['trade' => 'Vous avez deja ce trade actif ou en attente.']);
        }

        $userTrade = UserTrade::create([
            'user_id' => Auth::id(),
            'trade_id' => $trade->id,
            'category_id' => $trade->category_id,
            'amount' => $trade->amount,
            'daily_gain' => $trade->dailyGain(),
            'status' => 'pending',
        ]);

        return view('client.deposits.create', [
            'userTrade' => $userTrade->load('trade.category'),
            'paymentMethods' => PaymentMethod::with('exchangeRate')->active()->get(),
        ]);
    }
}
