<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Crud\PaymentController;
use App\Http\Controllers\Api\Crud\SaleController;
use App\Http\Controllers\Api\Crud\SaleItemController;
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
Route::post('/login', [AuthController::class, 'login']);

// Route::name('admin')->middleware(['jwt.auth'])->group(function () {
Route::apiResource('sale', SaleController::class)->except(['destroy']);
Route::apiResource('saleItem', SaleItemController::class)->except(['destroy']);
Route::apiResource('payment', PaymentController::class)->except(['destroy']);

// });
