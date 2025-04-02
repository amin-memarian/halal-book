<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\LanguageCollection;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguagesController extends Controller
{
    public function getAll(): LanguageCollection
    {
        return new LanguageCollection(Language::all());
    }
}
