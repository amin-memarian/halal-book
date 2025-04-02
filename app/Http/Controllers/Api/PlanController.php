<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PlanResource;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PlanController extends Controller
{

    public function index()
    {
        $plans = Plan::query()->get();

        return Response::success('پلن های سایت', PlanResource::collection($plans ?: []), 200);
    }

}
