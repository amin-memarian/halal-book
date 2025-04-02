<?php

namespace App\Providers;

use App\Models\GiftCard;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\User;
use App\Observers\GiftCardObserver;
use App\Observers\PaymentObserver;
use App\Observers\SubscriptionObserver;
use App\Observers\UserObserver;
use App\Repositories\GiftCardRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\SubscriptionRepository;
use App\Repositories\WalletRepository;
use App\Services\Payment\Adapters\ZarinpalAdapter;
use App\Services\Payment\PaymentGatewayInterface;
use App\Services\Payment\PaymentService;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(WalletRepository::class, function ($app) {
            return new WalletRepository();
        });

        $this->app->bind(PaymentRepository::class, function ($app) {
            return new PaymentRepository();
        });

        $this->app->bind(GiftCardRepository::class, function ($app) {
            return new GiftCardRepository();
        });

        $this->app->bind(SubscriptionRepository::class, function ($app) {
            return new SubscriptionRepository();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        Response::macro('success', function($message, $data = null, $status = 1) {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'data' => $data,
                'code' => 200
            ]);
        });

        Response::macro('failed', function($message, $data = null, $code = 500, $status = 0) {
            return response()->json([
                'status' => $status,
                'error' => $message,
                'data' => $data,
                'code' => $code
            ]);
        });

        User::observe(UserObserver::class);
        Payment::observe(PaymentObserver::class);
        GiftCard::observe(GiftCardObserver::class);
        Subscription::observe(SubscriptionObserver::class);

    }
}
