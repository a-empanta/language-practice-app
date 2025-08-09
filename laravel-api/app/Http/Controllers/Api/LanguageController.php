<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use Illuminate\Http\JsonResponse;

class LanguageController extends Controller
{
    public function getAvailableLanguages(): JsonResponse
    {
        return response()->json([
            'languages' => Language::pluck('id', 'name')->toArray(),
        ]);
    }
}
