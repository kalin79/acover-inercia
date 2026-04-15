<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'titulo',
        'descripcion',
        'slug',
        'banner_pc',      // ← nuevo
        'banner_mobile'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Características / Filtros asignados a esta categoría
     */
    public function features()
    {
        return $this->belongsToMany(Feature::class, 'category_feature')
            ->withPivot('is_filter', 'show_in_specs', 'sort_order')
            ->with(['options']);     // para traer los colores, etc.
        // ->orderBy('category_feature.sort_order', 'ASC');
    }

    /**
     * Solo los filtros activos (los que se muestran en la web)
     */
    public function activeFilters()
    {
        return $this->features()
            ->wherePivot('is_filter', true)
            ->orderBy('pivot.sort_order')
            ->get();
    }
}