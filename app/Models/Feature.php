<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = [
        'group',
        'name',
        'type',
        'feature_group_id'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_features')
            ->withPivot('value')
            ->withTimestamps();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_feature');
    }

    public function group()
    {
        return $this->belongsTo(FeatureGroup::class, 'feature_group_id');
    }

    public function options()
    {
        return $this->hasMany(FeatureOption::class);
    }
}