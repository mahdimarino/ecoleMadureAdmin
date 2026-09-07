<?php

use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/featured', [NewsController::class, 'featured']);
Route::get('/news/{slug}', [NewsController::class, 'show']);
Route::post('/contact', [ContactController::class, 'contactUs']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
