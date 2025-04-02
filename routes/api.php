<?php

use App\Http\Controllers\Api\BookCaseController;
use App\Http\Controllers\Api\BookExcerptController;
use App\Http\Controllers\Api\BookMetaDataController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InviteController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\MyBookController;
use App\Http\Controllers\Api\MyPurchaseController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\PaymentHistoryController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\PodcastController;
use App\Http\Controllers\Api\ProductsController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\ScoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::get('/callback', [PaymentController::class, 'callback'])->name('payment.callback');

// Protected route example (requires authentication)
Route::middleware(['auth:sanctum', 'check.subscription'])->group(function () {

    // Profiles
    Route::post('profiles', [ProfileController::class, 'store']);
    Route::get('profiles', [ProfileController::class, 'index']);

    Route::get('my-books', [MyBookController::class, 'index']);

    // My book cases
    Route::delete('book-cases/{book_case}', [BookCaseController::class, 'removeBookCase']);
    Route::post('book-cases/store', [BookCaseController::class, 'storeBookCase']);
    Route::get('book-cases', [BookCaseController::class, 'index']);
    Route::get('book-cases/{book_case}/books', [BookCaseController::class, 'showBookCase']);
    Route::post('book-cases/{book_case}/books/{book}', [BookCaseController::class, 'addBook']);
    Route::delete('book-cases/{book_case}/books/{book}', [BookCaseController::class, 'removeBook']);

    // Review
    Route::get('reviews', [ReviewController::class, 'index']);
    Route::post('reviews/store', [ReviewController::class, 'store']);

    // About payments
    Route::post('/pay', [PaymentController::class, 'pay'])->name('payment.pay');
    Route::get('payment-history', [PaymentHistoryController::class, 'index']);
    Route::get('payment-tracking', [PaymentHistoryController::class, 'tracking']);

    // Cart
    Route::post('carts/store', [CartController::class, 'store']);
    Route::delete('carts/{id}', [CartController::class, 'destroy']);
    Route::get('carts', [CartController::class, 'index']);

    // Plans
    Route::get('plan', [PlanController::class, 'index']);

    // Book excerpt
    Route::post('book-excerpts/store', [BookExcerptController::class, 'store']);
    Route::get('my-book-excerpts', [BookExcerptController::class, 'myExcerpts']);
    Route::get('book-excerpts', [BookExcerptController::class, 'index']);
    Route::get('my-book-excerpts/comments/{book_excerpt_id}', [BookExcerptController::class, 'comments']);

    // Like
    Route::post('likes/toggle', [LikeController::class, 'toggleLike']);

    // Purchases
    Route::get('my-purchases', [MyPurchaseController::class, 'myPurchases']);

    // Book meta data
    Route::get('/book-meta/speakers', [BookMetaDataController::class, 'getSpeakers']);
    Route::get('/book-meta/translators', [BookMetaDataController::class, 'getTranslators']);
    Route::get('/book-meta/authors', [BookMetaDataController::class, 'getAuthors']);
    Route::get('/book-meta/publishers', [BookMetaDataController::class, 'getPublishers']);

    // Books
    Route::get('books', [ProductsController::class, 'index']);

    Route::get('podcasts', [PodcastController::class, 'index'])->middleware(['check.subscription', 'check.purchased']);

    Route::get('invite-code', [InviteController::class, 'getCode']);

    Route::get('score', [ScoreController::class, 'getScore']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

});
