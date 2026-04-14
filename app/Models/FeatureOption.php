<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class FeatureOption extends Model
{

    use SoftDeletes;
    protected $fillable = ['feature_id', 'value', 'codigo',];

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }
}
