<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FeatureOption;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function show($slug, Request $request)
    {
        $category = Category::where('slug', $slug)
            ->with(['features.options', 'products.media'])
            ->firstOrFail();

        $query = $category->products()
            ->with(['media', 'features.options']);

        // ==================== FILTRO POR NOMBRE (desde option.id) ====================
        foreach ($request->all() as $group => $optionIds) {
            if (is_array($optionIds) && !empty($optionIds)) {

                // Normalizar el nombre del grupo (reemplazar _ por espacio)
                $normalizedGroup = str_replace('_', ' ', $group);

                // Obtener los nombres reales de las opciones seleccionadas
                $optionNames = FeatureOption::whereIn('id', $optionIds)
                    ->pluck('value')
                    ->toArray();

                \Log::info("=== FILTRO RECIBIDO ===", [
                    'grupo_original' => $group,
                    'grupo_normalizado' => $normalizedGroup,
                    'option_ids' => $optionIds,
                    'nombres_a_buscar' => $optionNames
                ]);

                $query->whereHas('features', function ($q) use ($normalizedGroup, $optionNames) {
                    $q->where('group', $normalizedGroup)
                        ->where(function ($subQ) use ($optionNames) {
                            foreach ($optionNames as $name) {
                                $subQ->orWhereRaw("JSON_CONTAINS(product_features.value, ?)", ['"' . addslashes($name) . '"']);
                                $subQ->orWhere('product_features.value', 'LIKE', "%" . $name . "%");
                            }
                        });
                });
            }
        }
        // =====================================================================

        \Log::info('=== SQL GENERADO ===');
        \Log::info('SQL:', ['sql' => $query->toSql()]);
        \Log::info('Bindings:', ['bindings' => $query->getBindings()]);

        // Log del SQL corregido
        \Log::info('=== SQL GENERADO ===', [
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings()
        ]);

        $products = $query->paginate(12);

        \Log::info('=== RESULTADO FINAL ===', [
            'productos_encontrados' => $products->total(),
            'primer_producto' => $products->first()?->titulo ?? 'NINGUNO'
        ]);

        return Inertia::render('CategoryShow', [
            'category' => $category,
            'products' => $products,
            'filters' => $request->all(),
        ]);
    }
}