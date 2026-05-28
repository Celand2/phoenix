<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserTrade;
use App\Services\TradeService;

class UserTradeController extends Controller
{
    public function index()
    {
        return view('admin.user-trades.index', [
            'userTrades' => UserTrade::with(['user', 'trade', 'category'])->latest()->paginate(20),
        ]);
    }

    public function expire(UserTrade $userTrade, TradeService $tradeService)
    {
        $tradeService->expireTrade($userTrade);

        return back()->with('status', 'Trade expire.');
    }
}
