<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invite;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ScoreController extends Controller
{
    public function getScore()
    {
        $score = Invite::query()->where('user_id', Auth::id())->sum('score');
        return Response::success('امتیاز شما', ['score' => $score], 200);
    }
}
