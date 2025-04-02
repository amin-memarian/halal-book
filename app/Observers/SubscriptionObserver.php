<?php

namespace App\Observers;

use App\Helpers\Helper;
use App\Models\Subscription;

class SubscriptionObserver
{

    /**
     * Handle the Subscription "creating" event.
     */
    public function creating(Subscription $subscription): void
    {
        $subscription->tracking_code = Helper::generateUniqueCode("SUB");
    }

    /**
     * Handle the Subscription "created" event.
     */
    public function created(Subscription $subscription): void
    {
        //
    }

    /**
     * Handle the Subscription "updated" event.
     */
    public function updated(Subscription $subscription): void
    {
        //
    }

    /**
     * Handle the Subscription "deleted" event.
     */
    public function deleted(Subscription $subscription): void
    {
        //
    }

    /**
     * Handle the Subscription "restored" event.
     */
    public function restored(Subscription $subscription): void
    {
        //
    }

    /**
     * Handle the Subscription "force deleted" event.
     */
    public function forceDeleted(Subscription $subscription): void
    {
        //
    }
}
