<?php

namespace App\Services;

use App\Models\User;
use App\Models\Withdrawal;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;

class WithdrawalService
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function create(
        User $user,
        PaymentMethod $paymentMethod,
        float $amount,
        string $accountNumber,
        string $accountName
    ): bool {
        if ($amount > $user->balance_gains) return false;

        DB::transaction(function () use ($user, $paymentMethod, $amount, $accountNumber, $accountName) {
            $fee = $amount * 0.10;
            $amountReceived = $amount - $fee;

            Withdrawal::create([
                'user_id' => $user->id,
                'payment_method_id' => $paymentMethod->id,
                'amount_requested' => $amount,
                'fee' => $fee,
                'amount_received' => $amountReceived,
                'status' => 'pending',
                'account_number' => $accountNumber,
                'account_name' => $accountName,
            ]);

            $user->decrement('balance_gains', $amount);

            $this->notificationService->send(
                $user,
                'Demande de Retrait',
                'Votre demande de retrait de ' . $amount . ' est en cours de traitement.',
                'withdrawal_pending'
            );
        });

        return true;
    }

    public function approve(Withdrawal $withdrawal): void
    {
        if ($withdrawal->status !== 'pending') {
            return;
        }

        DB::transaction(function () use ($withdrawal) {
            $withdrawal->update([
                'status' => 'approved',
                'approved_at' => now(),
            ]);

            $this->notificationService->send(
                $withdrawal->user,
                'Retrait Approuve',
                'Votre retrait de ' . $withdrawal->amount_received . ' a ete approuve.',
                'withdrawal_approved'
            );
        });
    }

    public function reject(Withdrawal $withdrawal): void
    {
        if ($withdrawal->status !== 'pending') {
            return;
        }

        DB::transaction(function () use ($withdrawal) {
            $withdrawal->update(['status' => 'rejected']);

            $withdrawal->user->increment('balance_gains', $withdrawal->amount_requested);

            $this->notificationService->send(
                $withdrawal->user,
                'Retrait Rejete',
                'Votre retrait de ' . $withdrawal->amount_requested . ' a ete rejete et rembourse.',
                'withdrawal_rejected'
            );
        });
    }
}
