<?php

namespace App\Repositories;

use App\Models\Plan;
use App\Models\Subscription;
use Carbon\Carbon;

class SubscriptionRepository extends BaseRepository
{
     public function __construct()
     {
         $this->model = new Subscription();
     }

    public function handleActivate($userId, $planId)
    {
        $newSubscription = $this->prepareData($userId, $planId);
        return $this->model->query()->create($newSubscription);
    }

    public function renew(int $subscriptionId, int $durationInDays): bool
    {
        $subscription = $this->model->query()->find($subscriptionId);

        if (!$subscription || $subscription->status !== 'active') {
            return false;
        }

        return $subscription->update([
            'expires_at' => Carbon::parse($subscription->expires_at)->addDays($durationInDays),
        ]);
    }

    public function cancel(int $userId): bool
    {
        return $this->model->query()
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->update(['status' => 'expired']);
    }

    private function prepareData($userId, $planId) {

         $plan = Plan::query()->find($planId);
         return [
             'user_id'   => $userId,
             'plan_id'   => $planId,
             'starts_at' => now(),
             'expires_at' => now()->addDays($plan->days),
             'status'    => 'active',
         ];
    }

}
