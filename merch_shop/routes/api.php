<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageApiController;
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\NewsApiController;
use App\Http\Controllers\CatalogApiController;
use App\Http\Controllers\AppealApiController;
use App\Http\Controllers\ProductApiController;
use App\Http\Controllers\CartApiController;
use App\Http\Controllers\OrderApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group( function () {
    Route::get('user', [AuthApiController::class, 'user']);
    Route::post('logout', [AuthApiController::class, 'logout']);
});

Route::post('login', [AuthApiController::class, 'login']);
Route::post('register', [AuthApiController::class, 'register']);

Route::prefix('catalog')->group(function () {
    Route::get('product/list', [ProductApiController::class, 'index']);
    Route::get('product/details', [ProductApiController::class, 'show']);
});

Route::post('/cart/set_quantity',CartApiController::class)->middleware('auth.optional');

Route::post('/order/store', [ OrderApiController::class, 'store']);

Route::apiResource('news', NewsApiController::class)->only([
    'index',
    'show',
]);

Route::apiResource('pages', PageApiController::class)->only([
    'index',
    'show',
]);

Route::apiResource('appeal', AppealApiController::class)->only([
    'store',
]);

Route::apiResource('catalog', CatalogApiController::class)->only([
    'index',
    'show',
]);
