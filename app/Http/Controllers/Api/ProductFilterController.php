<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductFilterController extends Controller
{
    public function filter(Request $request)
    {
        $query = Product::with(['media', 'category']);

        // ==================== FILTRO POR ID DE OPCIÓN (VERSIÓN RECOMENDADA) ====================
        foreach ($request->all() as $group => $optionIds) {
            if (is_array($optionIds) && !empty($optionIds)) {

                $normalizedGroup = str_replace('_', ' ', $group);

                // Obtener los nombres reales de las opciones seleccionadas
                $optionNames = \App\Models\FeatureOption::whereIn('id', $optionIds)
                    ->pluck('value')
                    ->toArray();

                \Log::info("=== FILTRO RECIBIDO ===", [
                    'grupo_original' => $group,
                    'grupo_normalizado' => $normalizedGroup,
                    'option_ids' => $optionIds,
                    'nombres_a_buscar' => $optionNames
                ]);

                if (!empty($optionNames)) {
                    $query->whereHas('features', function ($q) use ($normalizedGroup, $optionNames) {
                        $q->where('group', $normalizedGroup)
                            ->where(function ($subQ) use ($optionNames) {
                                foreach ($optionNames as $name) {
                                    $subQ->orWhereRaw("JSON_CONTAINS(product_features.value, ?)", ['"' . addslashes($name) . '"']);
                                    $subQ->orWhere('product_features.value', 'LIKE', "%{$name}%");
                                }
                            });
                    });
                }
            }
        }

        // ==================== BÚSQUEDA POR TEXTO ====================
        if ($request->filled('search')) {
            $search = trim($request->search);

            \Log::info("Búsqueda por texto", ['search' => $search]);

            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'LIKE', "%{$search}%")
                    ->orWhere('descripcion', 'LIKE', "%{$search}%")
                    ->orWhere('subtitulo', 'LIKE', "%{$search}%");
            });
        }

        // ==================== EJECUCIÓN ====================
        $products = $query->paginate(12);

        \Log::info('Resultado de filtro', [
            'total_productos' => $products->total(),
            'pagina_actual' => $products->currentPage(),
            'total_paginas' => $products->lastPage()
        ]);

        return response()->json([
            'success' => true,
            'data' => $products->items(),
            'total' => $products->total(),
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
            'per_page' => $products->perPage(),
            'from' => $products->firstItem(),
            'to' => $products->lastItem(),
            'next_page_url' => $products->nextPageUrl(),
            'prev_page_url' => $products->previousPageUrl(),
        ]);
    }
}