<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
Route::get('/search', [SearchController::class, 'searchApi'])->name('search');
