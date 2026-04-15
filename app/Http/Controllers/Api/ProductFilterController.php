<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductFilterController extends Controller
{
    public function filter(Request $request)
    {
        $categorySlug = $request->input('category_slug');

        if (!$categorySlug) {
            return response()->json([
                'success' => false,
                'message' => 'category_slug es requerido'
            ], 400);
        }

        $query = Product::with(['media', 'category'])
            ->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });

        // ==================== FILTROS POR OPCIÓN ====================
        foreach ($request->all() as $group => $optionIds) {
            if ($group === 'category_slug' || $group === 'search' || $group === 'page') {
                continue; // ignorar parámetros especiales
            }

            if (is_array($optionIds) && !empty($optionIds)) {
                $normalizedGroup = str_replace('_', ' ', $group);

                $optionNames = \App\Models\FeatureOption::whereIn('id', $optionIds)
                    ->pluck('value')
                    ->toArray();

                \Log::info("=== FILTRO RECIBIDO ===", [
                    'grupo' => $normalizedGroup,
                    'option_ids' => $optionIds,
                    'nombres' => $optionNames
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

        // Búsqueda por texto
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'LIKE', "%{$search}%")
                    ->orWhere('descripcion', 'LIKE', "%{$search}%")
                    ->orWhere('subtitulo', 'LIKE', "%{$search}%");
            });
        }

        $products = $query->paginate(12);

        \Log::info('Resultado final', [
            'categoria' => $categorySlug,
            'total_productos' => $products->total()
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
        ]);
    }
}