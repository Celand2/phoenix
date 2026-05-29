<?php

namespace App\Support;

use App\Models\PaymentMethod;
use App\Models\User;

class Money
{
    public const BASE_CURRENCY = 'USD';

    public static function formatUsd(float|string|null $amount): string
    {
        return self::format($amount, self::BASE_CURRENCY);
    }

    public static function format(float|string|null $amount, ?string $currency): string
    {
        $value = (float) ($amount ?? 0);
        $decimals = self::decimals($currency);

        return number_format($value, $decimals, '.', ' ') . ' ' . strtoupper($currency ?: self::BASE_CURRENCY);
    }

    public static function formatForUser(float|string|null $amountUsd, ?User $user): string
    {
        if (! $user?->preferred_currency || ! $user?->preferred_rate) {
            return self::formatUsd($amountUsd);
        }

        return self::format(self::toLocal($amountUsd, $user->preferred_rate), $user->preferred_currency);
    }

    public static function formatForUserWithUsd(float|string|null $amountUsd, ?User $user): string
    {
        $usd = self::formatUsd($amountUsd);

        if (! $user?->preferred_currency || ! $user?->preferred_rate) {
            return $usd;
        }

        return self::formatForUser($amountUsd, $user) . ' (' . $usd . ')';
    }

    public static function formatSnapshot(
        float|string|null $amountUsd,
        float|string|null $amountLocal,
        ?string $currencyLocal
    ): string {
        $usd = self::formatUsd($amountUsd);

        if (! $amountLocal || ! $currencyLocal || strtoupper($currencyLocal) === self::BASE_CURRENCY) {
            return $usd;
        }

        return $usd . ' / ' . self::format($amountLocal, $currencyLocal);
    }

    public static function toLocal(float|string|null $amountUsd, float|string|null $rate): float
    {
        return round((float) ($amountUsd ?? 0) * (float) ($rate ?? 1), 2);
    }

    public static function toUsd(float|string|null $amountLocal, float|string|null $rate): float
    {
        $rate = (float) ($rate ?? 1);

        return round((float) ($amountLocal ?? 0) / max($rate, 0.000001), 2);
    }

    public static function snapshotFor(PaymentMethod $paymentMethod): array
    {
        $paymentMethod->loadMissing('exchangeRate');
        $rate = $paymentMethod->exchangeRate;

        if (! $rate || ! $rate->is_active) {
            return [
                'currency' => self::BASE_CURRENCY,
                'rate' => 1.0,
            ];
        }

        return [
            'currency' => strtoupper($rate->currency_to),
            'rate' => (float) $rate->rate,
        ];
    }

    private static function decimals(?string $currency): int
    {
        return strtoupper((string) $currency) === 'FBU' ? 0 : 2;
    }
}
