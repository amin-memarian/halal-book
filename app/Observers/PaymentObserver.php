<?php

namespace App\Observers;

use App\Helpers\Helper;
use App\Models\Payment;

class PaymentObserver
{

    /**
     * Handle the Payment "creating" event.
     */
    public function creating(Payment $payment): void
    {
        $payment->tracking_code = Helper::generateUniqueCode('TXN');
    }

    /**
     * Handle the Payment "created" event.
     */
    public function created(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "updated" event.
     */
    public function updated(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "deleted" event.
     */
    public function deleted(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "restored" event.
     */
    public function restored(Payment $payment): void
    {
        //
    }

    /**
     * Handle the Payment "force deleted" event.
     */
    public function forceDeleted(Payment $payment): void
    {
        //
    }
}
