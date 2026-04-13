<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureGroup extends Model
{
    protected $fillable = ['name'];

    public function features()
    {
        return $this->hasMany(Feature::class);
    }
}