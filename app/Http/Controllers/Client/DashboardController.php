<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\UserTrade;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('client.dashboard.index', [
            'user' => $user,
            'activeTradesCount' => UserTrade::where('user_id', $user->id)->active()->count(),
            'pendingDepositsCount' => Deposit::where('user_id', $user->id)->pending()->count(),
            'pendingWithdrawalsCount' => Withdrawal::where('user_id', $user->id)->pending()->count(),
        ]);
    }
}
