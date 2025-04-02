<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BookCaseResource;
use App\Models\BookCase;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class BookCaseController extends Controller
{



    public function __construct(Request $request)
    {
    }

    public function index()
    {
        $bookCases = BookCase::query()
            ->where('user_id', Auth::id())
            ->with('books')
            ->withCount('books')
            ->orderByDesc('id')
            ->get();

        return Response::success('لیست قفسه های من', BookCaseResource::collection($bookCases), 200);

    }

    public function removeBookCase(BookCase $bookCase)
    {
        try {

            if (@$bookCase) {

                $bookCase->books()->delete();
                $bookCase->delete();

                return Response::success('قفسه و کتاب هاش حذف شدن', null, 200);

            } else {

                return Response::failed('چنین قفسه ای وجود ندارد', null, 500);

            }

        } catch (\Exception $e) {

            return Response::failed('قفسه با موفقیت ایجاد نشد', null, 500);

        }

    }

    public function storeBookCase(Request $request)
    {

        try {

            if (BookCase::query()->where('name', $request->name)->exists()) {

                return Response::success('این قفسه قبلا ایجاد شده است', null, 500);

            } else {

                BookCase::query()->create([
                    'user_id' => Auth::id(),
                    'name' => $request->name,
                ]);

                return Response::success('قفسه با موفقیت ایجاد شد', null, 200);

            }

        } catch (\Exception $e) {

            return Response::failed('قفسه با موفقیت ایجاد نشد', null, 500);

        }


    }

    public function showBookCase($bookCaseId)
    {

        try {

            $bookCase = BookCase::query()->where('user_id', Auth::id())
                ->where('id', $bookCaseId)
                ->orderByDesc('id')
                ->with('books')
                ->withCount('books')
                ->firstOrFail();

            return Response::success('لیست قفسه های من', new BookCaseResource($bookCase), 200);

        } catch (\Exception $e) {

            return Response::failed('قفسه ای پیدا نشد', [], 500);

        }

    }

    public function addBook($bookCaseId, $bookId)
    {

        try {

            $bookCase = BookCase::query()->where('user_id', Auth::id())
                ->where('id', $bookCaseId)
                ->with('books')
                ->withCount('books')
                ->firstOrFail();

            $bookCase->books()->syncWithoutDetaching([$bookId]);

            return Response::success('کتاب مورد نظر با موفقیت اضافه گردید', new BookCaseResource($bookCase ?? collect([])), 200);

        } catch (\Exception $e) {

            return Response::failed('کتاب مورد نظر پیدا نشد!', null, 500);

        }
    }

    public function removeBook($bookCaseId, $bookId)
    {
        try {

            $bookCase = BookCase::query()->where('user_id', Auth::id())
                ->where('id', $bookCaseId)
                ->with('books')
                ->withCount('books')
                ->firstOrFail();

            $bookCase->books()->detach($bookId);

            return Response::success('کتاب مورد نظر با موفقیت حذف گردید', new BookCaseResource($bookCase ?? collect([])), 200);

        } catch (\Exception $e) {

            return Response::failed('کتاب مورد نظر پیدا نشد!', null, 500);

        }
    }

}
