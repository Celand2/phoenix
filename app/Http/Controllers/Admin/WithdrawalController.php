<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Services\WithdrawalService;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::with(['user', 'paymentMethod'])->latest()->paginate(20);
        $pendingWithdrawalsCopy = Withdrawal::with(['user', 'paymentMethod'])
            ->where('status', 'pending')
            ->latest()
            ->get()
            ->map(function ($withdrawal) {
                $userName = $withdrawal->user?->name ?? 'N/A';
                $userEmail = $withdrawal->user?->email ?? 'N/A';
                $method = $withdrawal->paymentMethod?->name ?? 'N/A';
                $amountRequested = \App\Support\Money::formatSnapshot($withdrawal->amount_requested, $withdrawal->amount_requested_local, $withdrawal->currency_local);
                $fee = \App\Support\Money::formatSnapshot($withdrawal->fee, $withdrawal->fee_local, $withdrawal->currency_local);
                $amountReceived = \App\Support\Money::formatSnapshot($withdrawal->amount_received, $withdrawal->amount_received_local, $withdrawal->currency_local);

                return "Retrait #{$withdrawal->id}\nUtilisateur: {$userName} ({$userEmail})\nPortefeuille: {$withdrawal->account_number}\nMéthode: {$method}\nMontant demandé: {$amountRequested}\nFrais: {$fee}\nNet reçu: {$amountReceived}\nStatut: {$withdrawal->status}";
            })
            ->implode("\n\n");

        return view('admin.withdrawals.index', [
            'withdrawals' => $withdrawals,
            'pendingWithdrawalsCopy' => $pendingWithdrawalsCopy,
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

    public function destroy(Withdrawal $withdrawal)
    {
        $withdrawal->delete();

        return back()->with('status', 'Retrait supprime.');
    }
}
