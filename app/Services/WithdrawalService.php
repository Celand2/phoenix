<?php

namespace App\Services;

use App\Models\User;
use App\Models\Withdrawal;
use App\Models\PaymentMethod;
use App\Support\Money;
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
        $snapshot = Money::snapshotFor($paymentMethod);
        $isFirstCurrencyChoice = ! $user->preferred_currency;
        $amountUsd = $isFirstCurrencyChoice ? $amount : Money::toUsd($amount, $user->preferred_rate);

        if ($amountUsd > $user->balance_gains) return false;

        DB::transaction(function () use ($user, $paymentMethod, $snapshot, $isFirstCurrencyChoice, $amount, $amountUsd, $accountNumber, $accountName) {
            if ($isFirstCurrencyChoice) {
                $user->update([
                    'preferred_payment_method_id' => $paymentMethod->id,
                    'preferred_currency' => $snapshot['currency'],
                    'preferred_rate' => $snapshot['rate'],
                ]);
            }

            $currency = $isFirstCurrencyChoice ? $snapshot['currency'] : $user->preferred_currency;
            $rate = $isFirstCurrencyChoice ? $snapshot['rate'] : (float) $user->preferred_rate;
            
            $feePercent = config('phoenix.withdrawal_fee_percent', 10);
            $fee = $amountUsd * ($feePercent / 100);
            
            $amountReceived = $amountUsd - $fee;
            $amountRequestedLocal = Money::toLocal($amountUsd, $rate);
            $feeLocal = Money::toLocal($fee, $rate);
            $amountReceivedLocal = Money::toLocal($amountReceived, $rate);

            Withdrawal::create([
                'user_id' => $user->id,
                'payment_method_id' => $paymentMethod->id,
                'amount_requested' => $amountUsd,
                'fee' => $fee,
                'amount_received' => $amountReceived,
                'amount_requested_local' => $amountRequestedLocal,
                'fee_local' => $feeLocal,
                'amount_received_local' => $amountReceivedLocal,
                'currency_local' => $currency,
                'exchange_rate' => $rate,
                'status' => 'pending',
                'account_number' => $accountNumber,
                'account_name' => $accountName,
            ]);

            $user->decrement('balance_gains', $amountUsd);

            $this->notificationService->send(
                $user,
                'Demande de Retrait',
                'Votre demande de retrait de ' . Money::formatSnapshot($amountUsd, $amountRequestedLocal, $currency) . ' est en cours de traitement.',
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
                'Votre retrait de ' . Money::formatSnapshot($withdrawal->amount_received, $withdrawal->amount_received_local, $withdrawal->currency_local) . ' a ete approuve.',
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
                'Votre retrait de ' . Money::formatSnapshot($withdrawal->amount_requested, $withdrawal->amount_requested_local, $withdrawal->currency_local) . ' a ete rejete et rembourse.',
                'withdrawal_rejected'
            );
        });
    }
}
