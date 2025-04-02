<?php

namespace App\Http\Controllers\Api;

use App\Enums\PaymentType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Purchase\PurchaseResource;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class MyPurchaseController extends Controller
{
    public function myPurchases(Request $request)
    {
        $payments = Payment::query()
            ->where('user_id', Auth::id())
            ->where('type', PaymentType::BOOK->value)
            ->get();

        return Response::success('خرید های من', PurchaseResource::collection($payments ?: []) ,200);
    }
}
