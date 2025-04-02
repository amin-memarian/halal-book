<?php

namespace App\Services\Payment;

interface PaymentGatewayInterface
{
    public function requestPayment(int $amount, array $options = []): array;
    public function verifyPayment(string $transactionId): array;

}
