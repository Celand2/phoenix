<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Services\NotificationService;
use App\Services\TradeService;

class DepositController extends Controller
{
    public function index()
    {
        return view('admin.deposits.index', [
            'deposits' => Deposit::with(['user', 'userTrade.trade', 'paymentMethod'])->latest()->paginate(20),
        ]);
    }

    public function approve(Deposit $deposit, TradeService $tradeService, NotificationService $notifications)
    {
        if ($deposit->status !== 'pending') {
            return back()->withErrors(['deposit' => 'Ce depot a deja ete traite.']);
        }

        $deposit->update(['status' => 'approved', 'approved_at' => now()]);
        $tradeService->activateTrade($deposit);
        $notifications->send($deposit->user, 'Depot approuve', 'Votre depot a ete approuve.', 'deposit_approved');

        return back()->with('status', 'Depot approuve.');
    }

    public function reject(Deposit $deposit, NotificationService $notifications)
    {
        if ($deposit->status !== 'pending') {
            return back()->withErrors(['deposit' => 'Ce depot a deja ete traite.']);
        }

        $deposit->update(['status' => 'rejected']);
        $notifications->send($deposit->user, 'Depot rejete', 'Votre depot a ete rejete.', 'deposit_rejected');

        return back()->with('status', 'Depot rejete.');
    }

    public function destroy(Deposit $deposit)
    {
        $deposit->delete();

        return back()->with('status', 'Depot supprime.');
    }
}
