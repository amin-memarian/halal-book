<?php

namespace App\Repositories;

use App\Enums\PaymentType;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new Payment();
    }

    public function index($limit = 4)
    {
        return $this->model->query()
            ->where('user_id', Auth::id())
            ->take($limit)
            ->orderByDesc('id')
            ->get();
    }

    public function tracking($code)
    {
        return $this->model->query()
            ->where('user_id', Auth::id())
            ->where('tracking_code', $code)
            ->first();
    }

    public function store($data)
    {
        $newPaymentData = $this->prepareData($data);

        return $this->model->query()->create($newPaymentData);

    }

    private function prepareData($data)
    {
        $friend_mobile = null;
        $book_ids = [];
        $planId = 0;

        switch ($data['type']) {
            case PaymentType::WALLET->value:
                break;
            case PaymentType::BOOK->value:
                $book_ids = $data['book_ids'];
                break;
            case PaymentType::GIFT_CARD->value:
                $friend_mobile = $data['mobile'];
                break;
            case PaymentType::SUBSCRIPTION->value:
                $planId = $data['plan_id'];
                break;
        }

        return [
            'user_id' => $data['user_id'],
            'transaction_id' => $data['transaction_id'],
            'paid_amount' => $data['paid_amount'],
            'gateway_name' => $data['gateway_name'],
            'book_ids' =>  $book_ids,
            'plan_id' => $planId,
            'friend_mobile' => $friend_mobile,
            'discount_amount' => 0,
            'type' => $data['type'],
            'status' => $data['status']
        ];
    }

}
