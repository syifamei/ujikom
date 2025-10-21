<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\DownloadController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public routes (no authentication required)
Route::get('/fotos/{foto}/likes', [LikeController::class, 'index']);
Route::get('/fotos/{foto}/comments', [CommentController::class, 'index']);
Route::post('/fotos/{foto}/like', [LikeController::class, 'toggle']);
Route::post('/fotos/{foto}/comments', [CommentController::class, 'store']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Download routes
    Route::post('/fotos/{foto}/request-download', [DownloadController::class, 'requestDownload']);
});