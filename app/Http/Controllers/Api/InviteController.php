<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class InviteController extends Controller
{
    public function getCode()
    {
        $user = Auth::user();

        if (!$user->invite_code) {
            $user->invite_code = Helper::generateUniqueCode('INV');
            $user->save();
        }
        return Response::success('کد دعوت', $user->invite_code, 200);
    }
}
