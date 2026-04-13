<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductFeature extends Pivot
{
    protected $fillable = ['value'];
}