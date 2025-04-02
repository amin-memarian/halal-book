<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Book\BookMetaDataResource;
use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class BookMetaDataController extends Controller
{
    public function getSpeakers()
    {
        $speakers = Author::query()->where('type', 'speaker')->get();
        return Response::success('لیست گویندگان', BookMetaDataResource::collection($speakers), 200);
    }

    public function getTranslators()
    {
        $translators = Author::query()->where('type', 'translator')->get();
        return Response::success('لیست مترجمین', BookMetaDataResource::collection($translators), 200);
    }

    public function getAuthors()
    {
        $authors = Author::query()->where('type', 'author')->get();
        return Response::success('لیست نویسندگان', BookMetaDataResource::collection($authors), 200);
    }

    public function getPublishers()
    {
        $publishers = Publisher::query()->get();
        return Response::success('لیست انتشارات ها', BookMetaDataResource::collection($publishers), 200);
    }

}
