<?php
use App\Http\Controllers\Api\V1\AccountController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\TransactionController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/account', [AccountController::class, 'getAccountDetails']);
    Route::get('/transactions', [TransactionController::class, 'getTransactions']);
    Route::post('/transfer', [AccountController::class, 'transfer']);
    Route::post('/deposit', [AccountController::class, 'deposit']);
});
