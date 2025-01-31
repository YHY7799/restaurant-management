<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('products.index');
});

Route::resource('products', ProductController::class);
Route::post('/products/{product}/inventory', [ProductController::class, 'addInventoryItem'])->name('products.addInventoryItem');
Route::patch('/products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggleStatus');

Route::resource('categories', CategoryController::class);
Route::resource('options', OptionController::class);
Route::resource('inventory', InventoryItemController::class);
Route::get('/inventory-items/search', [InventoryItemController::class, 'search']);
Route::resource('orders', OrderController::class);
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');

Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');

Route::delete('/product-images/{productImage}', [ProductImageController::class, 'destroy'])
     ->name('product-images.destroy');
