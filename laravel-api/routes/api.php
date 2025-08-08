<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\TopicCategoryController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'returnUser']);

    Route::get('/validate-token', [AuthController::class, 'validateToken']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/topic-categories', [TopicCategoryController::class, 'index']);

    Route::get('/get-latest-conversation', [ConversationController::class, 'getLatestConversation']);

    Route::post('/new-conversation', [ConversationController::class, 'newConversation']);

    Route::get('/conversations/{id}', [ConversationController::class, 'show']);

    Route::post('/prompt/{id}', [ConversationController::class, 'reply']);

    Route::get('/get-available-languages', [ConversationController::class, 'getAvailableLanguages']);

    Route::get('/speech/{filename}', function ($filename) {
        $userId = auth()->id();

        // Prevent users from accessing others' files
        if (! Str::startsWith($filename, "user-{$userId}/")) {
            abort(403, 'Unauthorized');
        }

        // Stream the private S3 object through your app
        return Storage::disk('s3')->response($filename);
    });
});

Route::get('/health-check', function (Request $request) {
    \Log::info('here');
    return ['message' => 'Service working'];
});
