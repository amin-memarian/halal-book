<?php

namespace App\Repositories;

use App\Models\GiftCard;

class GiftCardRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new GiftCard();
    }

    public function store($paid_amount, $userId)
    {
        $giftCard = $this->model->query()->create([
            'amount' => $paid_amount,
            'type' => 'active'
        ]);

        $giftCard->users()->syncWithoutDetaching([$userId]);
    }

}
