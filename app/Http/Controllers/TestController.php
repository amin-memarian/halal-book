<?php

namespace App\Http\Controllers;

use App\Enums\PaymentType;
use App\Helpers\Helper;
use App\Models\BookExcerpt;
use App\Models\Comment;
use App\Models\Invite;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{
    public function index()
    {
    }
}
