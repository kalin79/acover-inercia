<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Inertia\Inertia;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->with(['products.media', 'features'])  // cargamos productos y sus imágenes
            ->firstOrFail();

        return Inertia::render('CategoryShow', [
            'category' => $category,
            'products' => $category->products,
            'title' => $category->titulo,
        ]);
    }
}
