<?php

namespace App\Services;

use App\Models\Deposit;
use App\Models\UserTrade;
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
        if (!$userTrade->isClaimable()) return false;

        DB::transaction(function () use ($userTrade) {
            $claimedAt = now();
            $nextClaimAt = now()->addHours(24);

            $userTrade->claims()->create([
                'user_id' => $userTrade->user_id,
                'amount' => $userTrade->daily_gain,
                'claimed_at' => $claimedAt,
                'next_claim_at' => $nextClaimAt,
            ]);

            $userTrade->update(['last_claimed_at' => $claimedAt]);

            $userTrade->user->increment('balance_gains', $userTrade->daily_gain);

            if (now()->greaterThanOrEqualTo($userTrade->expires_at)) {
                $this->expireTrade($userTrade);
            }

            $this->notificationService->send(
                $userTrade->user,
                'Gain Reclame',
                'Vous avez reclame ' . $userTrade->daily_gain . ' avec succes !',
                'claim_success'
            );
        });

        return true;
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
