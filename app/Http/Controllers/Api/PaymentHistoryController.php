<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PaymentResource;
use App\Repositories\PaymentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PaymentHistoryController extends Controller
{

    public function __construct(private readonly PaymentRepository $repository)
    {
    }

    public function index(Request $request)
    {
        $paymentHistory = $this->repository->index($request?->limit);

        return Response::success('تاریخچه پرداخت ها', $paymentHistory ? PaymentResource::collection($paymentHistory) : [], 200);
    }

    public function tracking(Request $request)
    {
        $payment = $this->repository->tracking($request?->code);
        return Response::success('جزئیات پرداخت', $payment ? new PaymentResource($payment) : [], 200);
    }

}
