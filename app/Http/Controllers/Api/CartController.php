<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Cart\CartResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class CartController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $perPage = $request->get('per_page', 10);

        // Apply pagination
        $cartItems = $user->cartItems()->paginate($perPage);

        // Prepare data
        $totalAmount = $user->cartItems()->sum(DB::raw('price * cart_items.quantity'));
        $bookIds = $user->cartItems()->pluck('cart_items.book_id')->toArray();

        return Response::success('سبد خرید شما', [
            'list' => CartResource::collection($cartItems),
            'pagination' => [
                'per_page' => $cartItems->perPage(),
                'current_page' => $cartItems->currentPage(),
                'total_pages' => $cartItems->lastPage(),
            ],
            'meta' =>
                [
                    'total_amount' => $totalAmount,
                    'book_ids' => $bookIds,
                ]
        ], 200);

    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $bookId = $request->book_id;

        if (!Product::query()->where('id', $bookId)->exists()) {
            return Response::failed('چنین کتابی در سایت وجود ندارد', null, 500);
        }

        $user->cartItems()->where('book_id', $bookId)->exists()
            ? $this->incrementCartItem($user, $bookId)
            : $this->addCartItem($user, $bookId);

        return $this->cartResponse($user, 'کتاب با موفقیت به سبد خرید اضافه شد');

    }

    public function destroy($bookId)
    {
        $user = auth()->user();

        if (!Product::query()->where('id', $bookId)->exists()) {
            return Response::failed('چنین کتابی در سایت وجود ندارد', null, 500);
        }

        $existingItem = $user->cartItems()->where('book_id', $bookId)->first();

        $existingItem?->pivot->quantity > 1
            ? $this->decrementCartItem($user, $bookId)
            : $this->removeCartItem($user, $bookId);

        return $this->cartResponse($user, 'کتاب با موفقیت از سبد خرید حذف شد');
    }


    private function incrementCartItem($user, $bookId)
    {
        $user->cartItems()->updateExistingPivot($bookId, [
            'quantity' => DB::raw('quantity + 1')
        ]);
    }

    private function decrementCartItem($user, $bookId)
    {
        $user->cartItems()->updateExistingPivot($bookId, [
            'quantity' => DB::raw('quantity - 1')
        ]);
    }

    private function addCartItem($user, $bookId)
    {
        $user->cartItems()->attach($bookId, ['quantity' => 1]);
    }

    private function removeCartItem($user, $bookId)
    {
        $user->cartItems()->detach($bookId);
    }

    private function cartResponse($user, $message)
    {
        $totalAmount = $user->cartItems()->sum(DB::raw('price * cart_items.quantity'));
        $bookIds = $user->cartItems()->pluck('cart_items.book_id')->toArray();

        $cartItems = $user->cartItems()->get();
        return Response::success($message, [
            'list' => CartResource::collection($cartItems ?: []),
            'meta' => [
                'total_amount' => $totalAmount,
                'book_ids' => $bookIds,
            ]
        ], 200);
    }


}
