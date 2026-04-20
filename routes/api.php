<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductFilterController;
use App\Http\Controllers\Api\CotizacionController;

Route::get('/test', function () {
    return response()->json([
        'message' => 'API funcionando correctamente - ' . now()
    ]);
});

Route::get('/products/filter', [ProductFilterController::class, 'filter']);

Route::post('/cotizacion', [CotizacionController::class, 'store']);
