<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Orders
Route::get('/orders', [OrderController::class, 'index']);

Route::get('/orders/create', [OrderController::class, 'create']);
Route::post('/orders/store', [OrderController::class, 'store']);

Route::get('/orders-list', [OrderController::class, 'list']);

Route::get('/orders/edit/{id}', [OrderController::class, 'edit']);
Route::post('/orders/update/{id}', [OrderController::class, 'update']);

Route::get('/orders/show/{id}', [OrderController::class, 'show']);

// Status toggle
Route::get('/orders/status/{id}', [OrderController::class, 'updateStatus']);

// Soft delete / restore / trash
Route::get('/orders/delete/{id}', [OrderController::class, 'delete']);
Route::get('/orders/restore/{id}', [OrderController::class, 'restore']);
Route::get('/orders/trashed', [OrderController::class, 'trashed']);

// CSV export
Route::get('/orders/export/csv', [OrderController::class, 'exportCsv']);

// Stores (Compoships composite relation) + multi-store dashboard
Route::get('/stores', [StoreController::class, 'index']);
Route::get('/dashboard', [StoreController::class, 'dashboard']);
