<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Services\WithdrawalService;

class WithdrawalController extends Controller
{
    public function index()
    {
        return view('admin.withdrawals.index', [
            'withdrawals' => Withdrawal::with(['user', 'paymentMethod'])->latest()->paginate(20),
        ]);
    }

    public function approve(Withdrawal $withdrawal, WithdrawalService $withdrawalService)
    {
        $withdrawalService->approve($withdrawal);

        return back()->with('status', 'Retrait approuve.');
    }

    public function reject(Withdrawal $withdrawal, WithdrawalService $withdrawalService)
    {
        $withdrawalService->reject($withdrawal);

        return back()->with('status', 'Retrait rejete.');
    }
}
