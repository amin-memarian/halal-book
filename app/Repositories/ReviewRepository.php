<?php

namespace App\Repositories;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class ReviewRepository extends BaseRepository
{
    public function __construct()
    {
        $this->model = new Comment();
    }

    public function index($request)
    {
        $limit = $request?->limit ?: 4;

        return $this->model->query()
            ->where('user_id', Auth::id())
            ->orderByDesc('id')
            ->with(['product', 'product.authors', 'product.publisher'])
            ->take($limit)
            ->get();
    }

    public function handleStore($request)
    {
        $newData = $this->prepareStoreData($request);

        $comment = $this->model->query()
            ->where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($comment) {

            $comment->update($newData);
            return $comment->fresh();

        } else {

            return $this->model->query()->create($newData);

        }

    }

    private function prepareStoreData($request)
    {
        return [
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'comment' => $request->comment,
            'rate' => $request->rate,
            'recommendation' => $request->recommendation,
        ];
    }

}
