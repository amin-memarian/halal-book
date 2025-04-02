<?php

namespace App\Enums;

enum PaymentType: string
{
    case WALLET = 'wallet';
    case BOOK = 'book';
    case GIFT_CARD = 'gift_card';
    case SUBSCRIPTION = 'subscription';

    public static function all(): array
    {
        return [
            self::WALLET->value,
            self::BOOK->value,
            self::GIFT_CARD->value,
        ];
    }

}
