<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($category_slug, $product_slug)
    {
        $product = Product::where('slug', $product_slug)
            ->with([
                'category',
                'features' => function ($query) {
                    $query->with('options');   // ← importante
                },
                'media'                    // ← AGREGAR ESTO
            ])
            ->firstOrFail();

        // Verificación extra de categoría (buena práctica)
        if ($product->category->slug !== $category_slug) {
            abort(404);
        }

        return inertia('ProductoDetalle', [
            'product' => $product,
            'category' => $product->category,
        ]);
    }
}