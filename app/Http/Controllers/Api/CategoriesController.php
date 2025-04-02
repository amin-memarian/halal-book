<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function getAll(Request $request): JsonResponse
    {
        $main_categories = Category::whereNull('parent_id')->get();
        $featured = Category::where('featured', true)->get();

        if ($request->filled('query')) {
            $main_categories = Category::where('name', 'like', '%'.$request->input('query').'%')->get();
        }

        return response()->json([
            'main_categories' => $main_categories,
            'featured' => $featured,
        ]);
    }

    public function getSubCategories(Category $category): JsonResponse
    {
        return response()->json([
            'sub_categories' => $category->children
        ]);
    }

    public function getProducts(Request $request, Category $category): JsonResponse
    {
        $products = $category->products();

        if ($request->filled('query')) {
            $products->where('name', 'like', '%'.$request->input('query').'%');
        }

        if ($request->filled('audio') && $request->input('audio') == '1') {
            $products->where('type', 'audio');
        }

        if ($request->filled('text') && $request->input('text') == '1') {
            $products->where('type', 'text');
        }

        if ($request->filled('publishers') && is_array($request->input('publishers'))) {
            $products->whereIn('publisher_id', $request->input('publishers'));
        }

        if ($request->filled('authors') && is_array($request->input('authors'))) {
            $products->whereIn('author_id', $request->input('authors'));
        }

        if ($request->filled('speakers') && is_array($request->input('speakers'))) {
            $products->whereIn('speaker_id', $request->input('speakers'));
        }

        if ($request->filled('translators') && is_array($request->input('translators'))) {
            $products->whereIn('translator_id', $request->input('translators'));
        }

        return response()->json([
            'products' => $products
        ]);
    }


    // Fetching
    public function getAllPublishers(Request $request): JsonResponse
    {
        $publishers = Publisher::query()->select('id', 'name');

        if ($request->filled('name')) {
            $publishers->where('name', 'like', '%'.$request->name.'%');
        }

        return response()->json([
           'publishers' => $publishers->get()
        ]);
    }

    public function getAllAuthors(Request $request): JsonResponse
    {
        $authors = Author::query()->where('type', 'author')->select('id', 'name');

        if ($request->filled('name')) {
            $authors->where('name', 'like', '%'.$request->name.'%');
        }

        return response()->json([
            'authors' => $authors->get()
        ]);
    }

    public function getAllSpeakers(Request $request): JsonResponse
    {
        $speakers = Author::query()->where('type', 'speaker')->select('id', 'name');

        if ($request->filled('name')) {
            $speakers->where('name', 'like', '%'.$request->name.'%');
        }

        return response()->json([
            'speakers' => $speakers->get()
        ]);
    }

    public function getAllTranslators(Request $request): JsonResponse
    {
        $authors = Author::query()->where('type', 'translator')->select('id', 'name');

        if ($request->filled('name')) {
            $authors->where('name', 'like', '%'.$request->name.'%');
        }

        return response()->json([
            'translators' => $authors->get()
        ]);
    }
}
