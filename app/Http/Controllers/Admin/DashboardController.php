<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\User;
use App\Models\UserTrade;
use App\Models\Withdrawal;

class DashboardController extends Controller{ 

    public function index()
    {
        return view('admin.dashboard.index', [
            'usersCount' => User::count(),
            'activeTradesCount' => UserTrade::active()->count(),
        'pendingDepositsCount' => Deposit::pending()->count(),
        'pendingWithdrawalsCount' => Withdrawal::pending()->count(),
        'totalPending' => Withdrawal::pending()->sum('amount_requested'),
        'totalApprovedToday' => Withdrawal::approved()->whereDate('approved_at', today())->sum('amount_received'),
    ]);
}
}