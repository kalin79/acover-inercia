<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Inertia\Inertia;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with(['media', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // === LOGS PARA VERIFICAR ===
        \Log::info('=== HOME - PRODUCTOS DESTACADOS ===');
        \Log::info('Cantidad de productos encontrados:', ['count' => $featuredProducts->count()]);

        if ($featuredProducts->isNotEmpty()) {
            \Log::info('Primer producto:', [
                'id' => $featuredProducts->first()->id,
                'titulo' => $featuredProducts->first()->titulo,
                'tiene_media' => $featuredProducts->first()->media->isNotEmpty(),
                'categoria' => $featuredProducts->first()->category?->titulo ?? 'Sin categoría'
            ]);
        } else {
            \Log::info('No se encontraron productos');
        }
        // ===========================

        return Inertia::render('Home', [
            'featuredProducts' => $featuredProducts,
        ]);
    }
}
