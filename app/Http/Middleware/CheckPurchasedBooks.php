<?php

namespace App\Http\Middleware;

use App\Models\Payment;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPurchasedBooks
{

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        $purchasedBooks = $user ?
            Payment::query()
            ->where('user_id', $user->id)
            ->where('status', '1')
            ->pluck('book_ids')
            ->flatten()
            ->unique()
            ->toArray()
            : [];

        $request->merge(['purchased_books' => $purchasedBooks]);

        return $next($request);
    }
}
