<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BookResource;
use App\Repositories\BookRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class MyBookController extends Controller
{

    public function __construct(private readonly BookRepository $repository)
    {
    }

    public function index(Request $request)
    {
        try {

            $data = [];

            // Variables: $textBooksCount, $audioBooksCount, $books
            extract($this->repository->index($request));

            $data['text_books_count'] = $textBooksCount;
            $data['audio_books_count'] = $audioBooksCount;
            $data['list'] = BookResource::collection($books);

            return Response::success('لیست کتاب های من', $data, 200);

        } catch (\Exception $e) {

            return Response::failed('کتابی پیدا نشد!', null, 500);

        }

    }

}
