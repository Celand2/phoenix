<?php

namespace App\Services;

use App\Models\User;
use App\Models\BonusCode;
use Illuminate\Support\Facades\DB;

class BonusCodeService
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function redeem(User $user, string $code): array
    {
        $bonusCode = BonusCode::where('code', $code)->first();

        if (!$bonusCode) {
            return ['success' => false, 'message' => 'Code invalide.'];
        }

        if (!$bonusCode->isUsable()) {
            return ['success' => false, 'message' => 'Ce code est expire ou invalide.'];
        }

        DB::transaction(function () use ($user, $bonusCode) {
            $bonusCode->increment('used_count');

            if ($bonusCode->used_count >= $bonusCode->max_uses) {
                $bonusCode->update(['status' => 'inactive']);
            }

            $user->increment('balance_gains', $bonusCode->amount);

            $this->notificationService->send(
                $user,
                'Bonus Code Utilise',
                'Vous avez recu ' . $bonusCode->amount . ' grace au code bonus.',
                'bonus_code_redeemed'
            );
        });

        return ['success' => true, 'message' => 'Code applique avec succes !', 'amount' => $bonusCode->amount];
    }
}
