<?php

namespace App\Services\Subscription;

use App\Repositories\SubscriptionRepository;
use Illuminate\Http\Request;

class SubscriptionService
{
    public function __construct(private readonly SubscriptionRepository $repository)
    {
    }


}
