<?php


use App\Http\Controllers\Api\V1\Admin\AdminController;
use App\Http\Controllers\Api\V1\AuthController;
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
        ->middleware(['auth:api_jwt','verifyIsAdmin'])->group(function (){
            Route::controller(AdminController::class)->group(function (){
                Route::post('create','create');
            });
    });
});
