<?php

use App\Http\Controllers\Api\MobileController;
use App\Http\Controllers\MpesaController;
use App\Http\Controllers\OpenAiController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::any('/validation', [MpesaController::class ,'validation_url'])->name('validation_url')->middleware(['mpesaIp']);
// Route::any('/confirmation', [MpesaController::class, 'confirmation'])->name('confirmation')->middleware(['mpesaIp']);
Route::any('/confirmation', [MpesaController::class, 'confirmation'])->name('confirmation');
Route::any('/stk_response/{order_no}', [MpesaController::class, 'stk_response']);

Route::middleware([])->prefix('mobile')->group(function () {
    Route::post('/login', [MobileController::class, 'login']);
    Route::post('/logout', [MobileController::class, 'logout']);
    // Route::post('/orders', [MobileController::class, 'placeOrder']);
    Route::get('/order/{id}', [MobileController::class, 'getOrder']);
    // Route::put('/orders/{id}', [MobileController::class, 'updateOrderStatus']);
    Route::get('/orders', [MobileController::class, 'getDriverOrders']);
    Route::get('/getOrder/{order_no}', [MobileController::class, 'getOrderDetails']);
    Route::get('/pending-orders', [MobileController::class, 'getPendingOrders']);
    Route::post('/location', [MobileController::class, 'updateDriverLocation']);
    Route::post('/orders/{id}/accept', [MobileController::class, 'acceptOrder']);



    Route::any('/map-track', [MobileController::class, 'map_track']);

});
