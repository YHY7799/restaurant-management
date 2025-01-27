<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\InventoryItemController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);
Route::resource('options', OptionController::class);
Route::resource('inventory', InventoryItemController::class);

Route::delete('/product-images/{productImage}', [ProductImageController::class, 'destroy'])
     ->name('product-images.destroy');
