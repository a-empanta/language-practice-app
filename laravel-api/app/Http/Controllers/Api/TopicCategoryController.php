<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TopicCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TopicCategoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'topicCategories'     => TopicCategory::withTopicSummaries(),
        ]);
    }
}
