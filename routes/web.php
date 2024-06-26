<?php

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
    Route::get('sales/{saleId}', [SalesController::class, 'show'])->name('sales.show');
    Route::post('/sales', [SalesController::class, 'store'])->name('sales.store');
    Route::put('/sales/{saleId}', [SalesController::class, 'update'])->name('sales.update');
    Route::delete('/sales/{saleId}', [SalesController::class, 'destroy'])->name('sales.destroy');
    Route::get('/sales/{id}/pdf', [SalesController::class, 'generatePdf'])->name('sales.pdf');

    Route::get('/clients', [ClientsController::class, 'index'])->name('clients.index');
    Route::get('clients/{clientId}', [ClientsController::class, 'show'])->name('clients.show');
    Route::post('/clients', [ClientsController::class, 'store'])->name('clients.store');
    Route::put('/clients/{clientId}', [ClientsController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{clientId}', [ClientsController::class, 'destroy'])->name('clients.destroy');

    Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
    Route::get('products/{productId}', [ProductsController::class, 'show'])->name('products.show');
    Route::post('/products', [ProductsController::class, 'store'])->name('products.store');
    Route::put('/products/{productId}', [ProductsController::class, 'update'])->name('products.update');
    Route::delete('/products/{productId}', [ProductsController::class, 'destroy'])->name('products.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
