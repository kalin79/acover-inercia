<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NosotrosController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/nosotros', [NosotrosController::class, 'index'])->name('nosotros');

Route::get('/categoria/{slug}', [CategoryController::class, 'show'])
    ->name('category.show');

Route::get('/producto/{category_slug}/{product_slug}', [ProductController::class, 'show'])
    ->name('product.show');