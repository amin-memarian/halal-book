<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        $hasSubscription = false;

        if ($user) {
            $subscription = $user->subscription()->first();

            if ($subscription) {

                if ($subscription->expires_at < Carbon::now() && $subscription->status !== 'expired') {
                    $subscription->update(['status' => 'expired']);
                }

                if ($subscription->status === 'active' && $subscription->expires_at >= Carbon::now()) {
                    $hasSubscription = true;
                }

            }
        }

        $request->merge(['has_subscription' => $hasSubscription]);

        return $next($request);
    }
}
