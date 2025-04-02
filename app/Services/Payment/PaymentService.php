<?php

namespace App\Services\Payment;

use App\Enums\PaymentType;
use App\Helpers\Helper;
use App\Models\User;
use App\Repositories\GiftCardRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\SubscriptionRepository;
use App\Repositories\WalletRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class PaymentService
{
    protected PaymentGatewayInterface $gateway;
    protected WalletRepository $walletRepository;
    protected PaymentRepository $paymentRepository;
    protected GiftCardRepository $giftCardRepository;
    protected SubscriptionRepository $subscriptionRepository;
    public function __construct(PaymentGatewayInterface $gateway,
                                WalletRepository $walletRepository,
                                PaymentRepository $paymentRepository,
                                GiftCardRepository $giftCardRepository,
                                SubscriptionRepository $subscriptionRepository
    ){
        $this->gateway = $gateway;
        $this->walletRepository = $walletRepository;
        $this->paymentRepository = $paymentRepository;
        $this->giftCardRepository = $giftCardRepository;
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function processPayment(int $amount, array $options = []): array
    {
        return $this->gateway->requestPayment($amount, $options);
    }

    public function verifyAndSavePayment(string $transactionId, int $userId): array
    {

        DB::beginTransaction();

        try {

            $paymentData = PaymentCacheManager::getPaymentSession($userId);

            $verify = $this->gateway->verifyPayment($transactionId);

            if (@$verify['status'] === 'success') {

                // Append successful status
                $mergedData = array_merge($paymentData, [
                    'status' => '1'
                ]);
                $successfulPaymentInformation = $this->paymentRepository->store($mergedData);

                /* Actions after successful payment*/
                $this->handleActions($paymentData, $successfulPaymentInformation);

                PaymentCacheManager::forgetPaymentSession($userId);

                DB::commit();

                return Response::success('پرداخت با موفقیت انجام شد', $successfulPaymentInformation, 200);

            } else {

                // Append failed status
                $mergedData = array_merge($paymentData, [
                    'status' => '1'
                ]);
                $failedPaymentInformation = $this->paymentRepository->store($mergedData);

                PaymentCacheManager::forgetPaymentSession($userId);

                DB::commit();


                return Response::success('پرداخت موفق نبود', $failedPaymentInformation, 500);

            }

        } catch (\Exception $e) {

            DB::rollBack();
        }

    }

    private function handleActions(array $paymentData, $successfulPaymentInformation): void
    {
        switch ($paymentData['type']) {
            case PaymentType::WALLET->value:
                $this->walletRepository->increaseBalance($paymentData['paid_amount'], $paymentData['user_id']);
                break;

            case PaymentType::BOOK->value:
                $successfulPaymentInformation->books()->syncWithoutDetaching($paymentData['book_ids']);
                break;

            case PaymentType::GIFT_CARD->value:
                $userId = User::query()->where('phone', $paymentData['mobile'])->pluck('id')->first();
                $this->giftCardRepository->store($paymentData['paid_amount'], $userId);
                break;

            case PaymentType::SUBSCRIPTION->value:
                $this->subscriptionRepository->handleActivate($paymentData['user_id'], $paymentData['plan_id']);
                break;
        }
    }

}
