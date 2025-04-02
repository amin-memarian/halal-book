<?php

namespace App\Services\Payment;

use Illuminate\Support\Facades\Cache;

class PaymentCacheManager
{
    public static function getSessionKey(int $userId): string
    {
        return 'gateway_info_' . $userId;
    }

    public static function storePaymentSession(array $data, int $userId, int $expireMinutes = 10): void
    {
        Cache::put(self::getSessionKey($userId), $data, now()->addMinutes($expireMinutes));
    }

    public static function getPaymentSession(int $userId): ?array
    {
        return Cache::get(self::getSessionKey($userId));
    }

    public static function forgetPaymentSession(int $userId): void
    {
        Cache::forget(self::getSessionKey($userId));
    }
}
