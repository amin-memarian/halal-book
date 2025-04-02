<?php

namespace App\Repositories;

use App\Models\Wallet;

class WalletRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new Wallet();
    }

    public function increaseBalance($amount, $userId)
    {
        $wallet = $this->model->query()->firstOrCreate(
            ['user_id' => $userId],
            ['balance' => 0]
        );

        return $wallet->increment('balance', $amount);
    }

    public function decreaseBalance($amount, $userId)
    {
        $wallet = $this->model->query()->where('user_id', $userId)->first();

        if ($wallet || $wallet->balance >= $amount) {

            return $wallet->decrement('balance', $amount);

        } else {

            return true;

        }

    }

    public function getBalance($user_id)
    {

    }

}
