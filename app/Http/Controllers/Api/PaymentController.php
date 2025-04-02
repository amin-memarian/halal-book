<?php

namespace App\Http\Controllers\Api;

use App\Enums\PaymentType;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Product;
use App\Models\Wallet;
use App\Repositories\GiftCardRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\SubscriptionRepository;
use App\Repositories\WalletRepository;
use App\Services\Payment\Adapters\ZarinpalAdapter;
use App\Services\Payment\PaymentCacheManager;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;

class PaymentController extends Controller
{

    private int $expire_time;


    public function __construct()
    {
        $this->expire_time = 6;
    }

    public function pay(Request $request)
    {

        $amount = $request->input('amount');
        $gatewayName = $request->input('gateway_name', 'zarinpal');

        $gateway = $this->resolveGateway($gatewayName);

        $paymentService = new PaymentService($gateway,
            app(WalletRepository::class),
            app(PaymentRepository::class),
            app(GiftCardRepository::class),
            app(SubscriptionRepository::class)
        );

        $paidAmount = $this->handlePaidAmount($request?->type, $request?->amount, $request?->book_ids ?: [], $request?->plan_id);


        $result = $paymentService->processPayment($paidAmount, ['user_id' => auth()->id()]);

        if ($result['status'] === 'success') {

            PaymentCacheManager::storePaymentSession(
                [
                    'user_id' => Auth::id(),
                    'transaction_id' => $result['transaction_id'],
                    'plan_id' => $request?->plan_id,
                    'paid_amount' => $paidAmount,
                    'gateway_name' => $request->gateway_name,
                    'book_ids' => $request->type == PaymentType::BOOK->value ? $request->book_ids : [],
                    'mobile' => $request?->mobile,
                    'discount_amount' => 0,
                    'type' => $request->type
                ]
                , Auth::id(), $this->expire_time + 4);

            $data = [
                'redirect_url' => $result['redirect_url'],
                'paid_amount' => $paidAmount,
                'expire_time' => $this->expire_time
            ];

            return Response::success('اطلاعات درگاه پرداخت', $data, 200);

        } else {

            return Response::failed('در حال حاضر درگاه پرداخت دردسترس نمی باشد!', null, 500);

        }

    }

    public function callback(Request $request)
    {

        $userId = $request?->user_id ?: 1;
        Auth::loginUsingId($userId);

        try {

            $gateway = new ZarinpalAdapter();

            $paymentService = new PaymentService($gateway,
                app(WalletRepository::class),
                app(PaymentRepository::class),
                app(GiftCardRepository::class),
                app(SubscriptionRepository::class)
            );

            $paymentService->verifyAndSavePayment($request['Authority'], Auth::id());

        } catch(\Exception $e) {
            dd(Helper::extractError($e));
        }
    }


    private function resolveGateway(string $gatewayName)
    {
        return match ($gatewayName) {
            'zarinpal' => new ZarinpalAdapter(),
            default => throw new \InvalidArgumentException('درگاه نامعتبر است'),
        };
    }

    private function handlePaidAmount($type, $amount, $bookIds, $planId)
    {
        $paidAmount = 0;

        switch ($type) {
            case PaymentType::GIFT_CARD->value:
            case PaymentType::WALLET->value:
                $paidAmount = $amount;
                break;

            case PaymentType::BOOK->value:
                if ($bookIds) {

                    foreach ($bookIds as $bookId) {
                        $book = Product::query()->find($bookId);
                        $paidAmount += $book->price;
                    }

                }
                break;

            case PaymentType::SUBSCRIPTION->value:
                $plan = Plan::query()->find($planId);
                $paidAmount = $plan->price;
                break;
        }

        return $paidAmount;

    }

}
