<?php

use App\Http\Controllers\Api\V1\Admin\AdminController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\Order\OrderController;
use App\Http\Controllers\Api\V1\Order\OrderStatusController;
use App\Http\Controllers\Api\V1\Product\ProductController;
use Illuminate\Support\Facades\Route;

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
Route::prefix('v1')->group(function (): void {
    Route::controller(AuthController::class)->prefix('auth')->group(function (): void {
        Route::post('login', 'login');
        Route::get('logout', 'logout')->middleware('auth:api_jwt');
    });
    Route::prefix('admin')
        ->middleware(['auth:api_jwt','verifyIsAdmin'])->group(function () {
            Route::controller(AdminController::class)->group(function () {
                Route::post('create', 'create');
            });
        });
    Route::middleware(['auth:api_jwt'])->group(function () {
        Route::controller(ProductController::class)->prefix('product')->group(function () {
            Route::post('create', 'create');
            Route::get('', 'index');
            Route::get('/{uuid}', 'show');
            Route::put('/{uuid}', 'update');
            Route::delete('/{uuid}', 'destroy');
        });

        Route::controller(OrderController::class)->prefix('order')->group(function () {
            Route::post('create', 'store');
            Route::get('/{uuid}', 'show');
            Route::put('/{uuid}', 'update');
            Route::delete('/{uuid}', 'destroy');
        });
        Route::get('orders', [OrderController::class,'index']);

        Route::get('/order-statuses', [OrderStatusController::class, 'index']);
        Route::get('/order-status/{uuid}', [OrderStatusController::class, 'show']);
    });
});
