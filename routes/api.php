<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

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

Route::get('test', [PaymentController::class, 'test']);
Route::post('force-pending', [PaymentController::class, 'forcePending']);
Route::post('force-success', [PaymentController::class, 'forceSuccess']);
Route::post('force-expired', [PaymentController::class, 'forceExpired']);

Route::post('/payment/midtrans-callback', [PaymentController::class, 'midtransCallback']);
