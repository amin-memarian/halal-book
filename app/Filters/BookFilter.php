<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BookFilter
{
    protected Builder $query;
    protected Request $request;

    public function __construct(Builder $query, Request $request)
    {
        $this->query = $query;
        $this->request = $request;
    }

    public function apply(): Builder
    {
        return $this->applyFilters();
    }

    private function applyFilters(): Builder
    {
        return $this->query
            ->when($this->request->filled('publisher_id'), fn($q) => $q->where('publisher_id', $this->request->publisher_id))

            ->when($this->request->filled('author_id'), fn($q) =>
                $q->whereHas('authors', fn($q) => $q->where('id', $this->request->author_id))
            )

            ->when($this->request->filled('category_id'), fn($q) =>
                $q->whereHas('categories', fn($q) => $q->where('id', $this->request->category_id))
            )

            ->when($this->request->filled('translator_id'), fn($q) =>
                $q->where('translator_id', $this->request->translator_id)
            )

            ->when($this->request->filled('speaker_id'), fn($q) =>
                $q->where('speaker_id', $this->request->speaker_id)
            )
            ->when($this->request->filled('type'), function ($q) {
                $type = strtolower($this->request->type);
                $validTypes = ['audio', 'text'];

                if (in_array($type, $validTypes)) {
                    $q->where('type', $type);
                }
            });

    }

}


