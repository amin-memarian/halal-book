<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BookExcerpt\BookExcerptCommentResource;
use App\Http\Resources\Api\BookExcerptResource;
use App\Models\BookExcerpt;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class BookExcerptController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $bookExcerpts = BookExcerpt::query()->orderByDesc('id')->get();
        return Response::success('لیست بریده کتاب ها', [
            'list' => BookExcerptResource::collection($bookExcerpts)
        ], 200);
    }

    public function myExcerpts()
    {
        $bookExcerpts = BookExcerpt::query()->withCount('comments')
            ->where('user_id', Auth::id())
            ->orderByDesc('id')
            ->get();

        return Response::success('لیست بریده کتاب های من', [
            'list' => BookExcerptResource::collection($bookExcerpts),
            'avatar' => Auth::user()?->profile?->avatar_image ? Helper::generateImageUrl(Auth::user()->profile->avatar_image) : ''
        ], 200);
    }

    public function store(Request $request)
    {
        if (!Product::query()->where('id', $request->book_id)->exists())
            return Response::failed('چنین کتابی در سایت وجود ندارد', null, 500);

        $bookExcerpt =  BookExcerpt::query()->create([
            'user_id' => Auth::id(),
            'book_id' => $request->book_id,
            'text' => $request->text,
        ]);

        return Response::success('برید کتاب با موفقیت ذخیره شد', new BookExcerptResource($bookExcerpt), 200);
    }

    public function comments($bookExcerptId)
    {
        $bookExcerpt = BookExcerpt::query()->with('comments')->find($bookExcerptId);

        if (!$bookExcerpt)
            return Response::failed('چنین بریده کتابی در سایت وجود ندارد', null, 500);

        return Response::success('نظرات بریده کتاب های من', [
            'list' => $bookExcerpt->comments ? BookExcerptCommentResource::collection($bookExcerpt->comments) : '',
        ], 200);

    }

}
