<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'titulo',
        'subtitulo',
        'descripcion',
        'slug',
        'banner_pc',           // nuevo
        'banner_mobile',       // nuevo
        'cover_image',         // nuevo
        'technical_document'   // nuevo
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'product_features')
            ->withPivot('value')
            ->with(['options'])                     // ← Agrega esto
            ->withTimestamps();
    }
    public function media()
    {
        return $this->hasMany(ProductMedia::class)->orderBy('sort_order');
    }
}