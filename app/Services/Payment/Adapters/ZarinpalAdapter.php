<?php

namespace App\Services\Payment\Adapters;

use App\Services\Payment\PaymentGatewayInterface;
use Illuminate\Support\Facades\Http;

class ZarinpalAdapter implements PaymentGatewayInterface
{
    protected string $merchantId;
    protected string $baseUrl;
    protected string $startPayUrl;

    public function __construct()
    {
        $this->merchantId = config('services.zarinpal.merchant_id', '00000000-0000-0000-0000-000000000000');
        $this->baseUrl = 'https://sandbox.zarinpal.com/pg/v4/payment';
        $this->startPayUrl = 'https://sandbox.zarinpal.com/pg/StartPay/';
    }

    public function requestPayment(int $amount, array $options = []): array
    {
        $callbackUrl = route('payment.callback');

        $response = Http::withOptions(['verify' => false])->post("{$this->baseUrl}/request.json", [
            'merchant_id' => $this->merchantId,
            'amount' => $amount,
            'description' => $options['description'] ?? 'خرید اینترنتی',
            'callback_url' => $callbackUrl,
        ]);

        $data = $response->json();

        if (isset($data['data']) && $data['data']['code'] == 100) {
            return [
                'status' => 'success',
                'redirect_url' => "{$this->startPayUrl}{$data['data']['authority']}",
                'transaction_id' => $data['data']['authority'],
            ];
        }

        return ['status' => 'error', 'message' => $data['errors']['message'] ?? 'خطا در دریافت لینک پرداخت'];
    }

    public function verifyPayment(string $transactionId): array
    {

    }
}
