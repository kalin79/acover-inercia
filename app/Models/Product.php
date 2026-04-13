<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'titulo', 'subtitulo', 'descripcion', 'slug'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'product_features')
            ->withPivot('value')
            ->withTimestamps();
    }
    public function media()
    {
        return $this->hasMany(ProductMedia::class)->orderBy('sort_order');
    }
}