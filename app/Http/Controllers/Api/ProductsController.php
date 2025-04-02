<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Book\FilteredBookResource;
use App\Http\Resources\Api\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ProductsController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', '10');

        $books = Product::filter($request)->paginate($perPage);

        return Response::success('لیست کتاب ها', [
            'list' => FilteredBookResource::collection($books),
            'pagination' => [
                'per_page' => $books->perPage(),
                'current_page' => $books->currentPage(),
                'total_pages' => $books->lastPage(),
            ]
        ], 200);
    }

    public function single(Product $product)
    {
        if (!$product->status) {
            return response()->json([
                'message' => 'Not found!'
            ], 404);
        }
        return new ProductResource($product);
    }
}
