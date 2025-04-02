<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Services\LikeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    protected $likeService;

    public function __construct(LikeService $likeService)
    {
        $this->likeService = $likeService;
    }

    public function toggleLike(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'likeable_type' => 'required|string',
            'likeable_id' => 'required|integer',
        ]);

        $this->likeService->toggleLike($validated['likeable_type'], $validated['likeable_id']);

        return response()->json([
            'liked' => Like::isLikedByUser(auth()->id(), $validated['likeable_type'], $validated['likeable_id']),
            'likes_count' => Like::countLikes($validated['likeable_type'], $validated['likeable_id']),
        ]);
    }

}
