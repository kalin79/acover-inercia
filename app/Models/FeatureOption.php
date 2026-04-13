<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureOption extends Model
{
    protected $fillable = ['feature_id', 'value'];

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }
}
