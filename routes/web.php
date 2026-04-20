<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NosotrosController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Legal\TerminosUsoController;
use App\Http\Controllers\Legal\TratamientoDatosController;

use App\Http\Controllers\Legal\PoliticasPrivacidadController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/nosotros', [NosotrosController::class, 'index'])->name('nosotros');

// Políticas y Legales
Route::get('/politicas-privacidad', [PoliticasPrivacidadController::class, 'index'])
     ->name('legal.politicas');

Route::get('/terminos-uso', [TerminosUsoController::class, 'index'])
     ->name('legal.terminos');

Route::get('/tratamiento-datos', [TratamientoDatosController::class, 'index'])
     ->name('legal.tratamiento-datos');


Route::get('/categoria/{slug}', [CategoryController::class, 'show'])
    ->name('category.show');

Route::get('/producto/{category_slug}/{product_slug}', [ProductController::class, 'show'])
    ->name('product.show');