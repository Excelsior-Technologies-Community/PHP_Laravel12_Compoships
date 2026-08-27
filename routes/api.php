<?php

use App\Http\Controllers\Api\OrderController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::apiResource('orders', OrderController::class);

    // Restore a soft-deleted order
    Route::post('/orders/{id}/restore', [OrderController::class, 'restore']);
});
