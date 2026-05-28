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
        return view('client.trades.index', ['trades' => Trade::with('category')->active()->paginate(20)]);
    }

    public function buy(Trade $trade)
    {
        $exists = UserTrade::where('user_id', Auth::id())
            ->where('category_id', $trade->category_id)
            ->whereIn('status', ['pending', 'active'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['trade' => 'Vous avez deja un trade actif ou en attente dans cette categorie.']);
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
            'paymentMethods' => PaymentMethod::active()->get(),
        ]);
    }
}
