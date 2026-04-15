<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductFilterController;


Route::get('/test', function () {
    return response()->json([
        'message' => 'API funcionando correctamente - ' . now()
    ]);
});

Route::get('/products/filter', [ProductFilterController::class, 'filter']);
