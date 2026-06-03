<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserTrade;
use App\Models\Referral;
use Illuminate\Support\Facades\DB;

class ReferralService
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function distributeCommissions(UserTrade $userTrade): void
    {
        $user = $userTrade->user;
        $amount = $userTrade->amount;

        $level1 = $user->referrer;
        if (!$level1) return;

        DB::transaction(function () use ($userTrade, $amount, $level1) {

            // Niveau 1
            $this->createCommission($level1, $userTrade, $amount, 1);

            // Niveau 2
            $level2 = $level1->referrer;
            if (!$level2) return;
            $this->createCommission($level2, $userTrade, $amount, 2);

            // Niveau 3
            $level3 = $level2->referrer;
            if (!$level3) return;
            $this->createCommission($level3, $userTrade, $amount, 3);
        });
    }

    private function createCommission(
        User $referrer,
        UserTrade $userTrade,
        float $amount,
        int $level
    ): void {
        $percent = $this->getCommissionPercent($level);
        if ($percent <= 0) return;

        $commission = $amount * $percent / 100;

        Referral::create([
            'referrer_id' => $referrer->id,
            'referred_id' => $userTrade->user_id,
            'level' => $level,
            'commission_percent' => $percent,
            'commission_amount' => $commission,
            'user_trade_id' => $userTrade->id,
            'status' => 'paid',
        ]);

        $referrer->increment('balance_gains', $commission);

        $this->notificationService->send(
            $referrer,
            'Commission de Parrainage',
            'Vous avez recu une commission de ' . $commission . ' niveau ' . $level . '.',
            'referral_commission'
        );
    }

    private function getCommissionPercent(int $level): float
    {
        $percents = config('phenix.referral_percents', [
            1 => 5.00,
            2 => 3.00,
            3 => 1.00,
        ]);

        return $percents[$level] ?? 0;
    }
}
