<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Resources\Api\ReviewResource;
use App\Repositories\ReviewRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ReviewController extends Controller
{
    public function __construct(private readonly ReviewRepository $repository)
    {
    }

    public function index(Request $request)
    {
        try {

            $comments = $this->repository->index($request);

            return Response::success('لیست نقد و امتیازات من', ReviewResource::collection($comments ?: []), 200);

        } catch (\Exception $e) {

            return Response::success('در حال حاضر نقد و امتیازی ندارید', [], 200);

        }

    }

    public function store(StoreReviewRequest $request)
    {
        try {

            $comment = $this->repository->handleStore($request);

            return Response::success('لیست نقد و امتیازات من', new ReviewResource($comment ?: []), 200);

        } catch (\Exception $e) {

            return Response::success('در حال حاضر نقد و امتیازی ندارید', [], 200);

        }
    }

}
