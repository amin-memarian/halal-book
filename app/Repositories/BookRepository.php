<?php

namespace App\Repositories;

use App\Models\BookTrack;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class BookRepository
{
    public function __construct()
    {
    }

    public function index($request)
    {
        $limit = $request?->limit ?: 4;

        $bookTrackIds = BookTrack::query()->where('user_id', Auth::id())->pluck('product_id');


        $booksQuery = Product::query()->whereIn('id', $bookTrackIds);
        $halfLimit = ceil($limit / 2);

        $textBooksCount = (clone $booksQuery)->where('type', 'text')
            ->count();

        $audioBooksCount = (clone $booksQuery)->where('type', 'audio')
            ->count();


        $textBooks = (clone $booksQuery)->where('type', 'text')
            ->take($halfLimit)
            ->get();

        $audioBooks = (clone $booksQuery)->where('type', 'audio')
            ->take($halfLimit)
            ->get();


        $books = $textBooks->merge($audioBooks);


        return compact('textBooksCount', 'audioBooksCount', 'books');
    }

}
