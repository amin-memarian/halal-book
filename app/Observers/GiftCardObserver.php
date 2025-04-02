<?php

namespace App\Observers;

use App\Helpers\Helper;
use App\Models\GiftCard;

class GiftCardObserver
{

    /**
     * Handle the Payment "creating" event.
     */
    public function creating(GiftCard $giftCard): void
    {
        $giftCard->tracking_code = Helper::generateUniqueCode('GC');
    }

    /**
     * Handle the GiftCard "created" event.
     */
    public function created(GiftCard $giftCard): void
    {
        //
    }

    /**
     * Handle the GiftCard "updated" event.
     */
    public function updated(GiftCard $giftCard): void
    {
        //
    }

    /**
     * Handle the GiftCard "deleted" event.
     */
    public function deleted(GiftCard $giftCard): void
    {
        //
    }

    /**
     * Handle the GiftCard "restored" event.
     */
    public function restored(GiftCard $giftCard): void
    {
        //
    }

    /**
     * Handle the GiftCard "force deleted" event.
     */
    public function forceDeleted(GiftCard $giftCard): void
    {
        //
    }
}
