<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});

// Orders
Route::get('/orders', [OrderController::class, 'index']);

Route::get('/orders/create', [OrderController::class, 'create']);
Route::post('/orders/store', [OrderController::class, 'store']);

Route::get('/orders-list', [OrderController::class, 'list']);

Route::get('/orders/show/{id}', [OrderController::class, 'show']);

// Status toggle
Route::get('/orders/status/{id}', [OrderController::class, 'updateStatus']);

// Delete
Route::get('/orders/delete/{id}', [OrderController::class, 'delete']);

Route::get('/orders/export/csv', [OrderController::class, 'exportCsv']);