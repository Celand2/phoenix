<?php

namespace App\Services;

use App\Models\Deposit;
use App\Models\UserTrade;
use App\Support\Money;
use Illuminate\Support\Facades\DB;

class TradeService
{
    protected ReferralService $referralService;
    protected NotificationService $notificationService;

    public function __construct(
        ReferralService $referralService,
        NotificationService $notificationService
    ) {
        $this->referralService = $referralService;
        $this->notificationService = $notificationService;
    }

    public function activateTrade(Deposit $deposit): void
    {
        DB::transaction(function () use ($deposit) {
            $userTrade = $deposit->userTrade;
            if ($userTrade->status !== 'pending') {
                return;
            }

            $trade = $userTrade->trade;
            $category = $userTrade->category;

            $dailyGain = $trade->amount * $category->daily_profit_percent / 100;

            $userTrade->update([
                'status' => 'active',
                'daily_gain' => $dailyGain,
                'activated_at' => now(),
                'expires_at' => now()->addDays($category->duration_days),
            ]);

            $deposit->user->increment('balance_invested', $trade->amount);

            $this->referralService->distributeCommissions($userTrade);

            $this->notificationService->send(
                $deposit->user,
                'Trade Active',
                'Votre trade ' . $trade->name . ' a ete active avec succes !',
                'trade_activated'
            );
        });
    }

   public function claimDailyGain(UserTrade $userTrade): bool
    {
        return DB::transaction(function () use ($userTrade) {
            $locked = UserTrade::whereKey($userTrade->getKey())->lockForUpdate()->first();

            if (! $locked || ! $locked->isClaimable()) {
                return false;
            }

            $claimedAt = now();
            $locked->claims()->create([
                'user_id' => $locked->user_id,
                'amount' => $locked->daily_gain,
                'claimed_at' => $claimedAt,
                'next_claim_at' => $claimedAt->copy()->addHours(24),
            ]);
            $locked->update(['last_claimed_at' => $claimedAt]);
            $locked->user->increment('balance_gains', $locked->daily_gain);

            if (now()->greaterThanOrEqualTo($locked->expires_at)) {
                $this->expireTrade($locked);
            }

            $this->notificationService->send(
                $locked->user,
                'Gain Reclame',
                'Vous avez reclame ' . Money::formatForUserWithUsd($locked->daily_gain, $locked->user) . ' avec succes !',
                'claim_success'
            );

            return true;
        });
    }
    public function expireTrade(UserTrade $userTrade): void
    {
        if ($userTrade->status !== 'active') {
            return;
        }

        $userTrade->update(['status' => 'expired']);

        $userTrade->user->decrement('balance_invested', $userTrade->amount);

        $this->notificationService->send(
            $userTrade->user,
            'Trade Expire',
            'Votre trade ' . $userTrade->trade->name . ' est arrive a terme.',
            'trade_expired'
        );
    }
}
