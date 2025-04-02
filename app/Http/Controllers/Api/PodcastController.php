<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Podcast\PodcastResource;
use App\Models\BookTrack;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class PodcastController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {

        if ($request->has_subscription) {

            $bookTrackIds = BookTrack::query()
                ->where('user_id', Auth::id())
                ->pluck('product_id');


            $books = Product::query()->where('type', 'audio')
                ->whereIn('id', $bookTrackIds)
                ->with('headlines')
                ->get();

        } else {

            $bookIds = $request->purchased_books;

            $bookTrackIds = BookTrack::query()
                ->where('user_id', Auth::id())
                ->whereIn('product_id', $bookIds)
                ->pluck('product_id');

            $books = Product::query()->where('type', 'audio')
                ->whereIn('id', $bookTrackIds)
                ->with('headlines')
                ->get();

        }

        return Response::success('لیست پادکست های من', [
            'list' => $books ? PodcastResource::collection($books) : []
        ], 200);

    }

}
