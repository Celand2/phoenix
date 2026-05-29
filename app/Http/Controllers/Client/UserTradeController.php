<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\UserTrade;
use App\Services\TradeService;
use App\Support\Money;
use Illuminate\Support\Facades\Auth;

class UserTradeController extends Controller
{
    public function index()
    {
        return view('client.my-trades.index', [
            'userTrades' => UserTrade::with(['trade', 'category'])->where('user_id', Auth::id())->latest()->paginate(20),
        ]);
    }

    public function claim(UserTrade $userTrade, TradeService $tradeService)
    {
        abort_unless($userTrade->user_id === Auth::id(), 403);

        if (! $tradeService->claimDailyGain($userTrade)) {
            return response()->json(['success' => false, 'message' => 'Gain indisponible.'], 422);
        }

        return response()->json([
            'success' => true,
            'balance_gains' => Money::formatForUser(Auth::user()->fresh()->balance_gains, Auth::user()->fresh()),
        ]);
    }
}
