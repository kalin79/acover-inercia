<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use App\Models\Product;
use App\Models\Feature;
use Filament\Resources\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\DB;

class EditProductFeature extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = ProductResource::class;

    protected string $view = 'filament.resources.products.pages.edit-product-feature';

    public Product $product;
    public Feature $feature;

    // Propiedad para checkboxes (select) y texto (input)
    public array|string|null $value = null;

    public function mount(int $record, Feature $feature): void
    {
        $this->product = Product::findOrFail($record);
        $this->feature = $feature;

        // Cargar valor existente
        $pivot = DB::table('product_features')
            ->where('product_id', $this->product->id)
            ->where('feature_id', $this->feature->id)
            ->first();

        if ($pivot && $pivot->value !== null) {
            if ($this->feature->type === 'select') {
                $this->value = is_string($pivot->value) 
                    ? json_decode($pivot->value, true) 
                    : (array) $pivot->value;

                // Limpiar array
                $this->value = array_map('trim', array_filter((array)$this->value));
            } else {
                $this->value = $pivot->value;
            }
        } else {
            // Valor por defecto según tipo
            $this->value = $this->feature->type === 'select' ? [] : '';
        }
    }

    public function cancel(): void
    {
        $this->redirect(ProductResource::getUrl('features', ['record' => $this->product]));
    }

    public function save(): void
    {
        if ($this->feature->type === 'select') {
            $finalValue = is_array($this->value) && !empty($this->value) 
                ? json_encode($this->value) 
                : null;
        } else {
            $finalValue = $this->value !== '' && $this->value !== null 
                ? $this->value 
                : null;
        }

        DB::table('product_features')
            ->where('product_id', $this->product->id)
            ->where('feature_id', $this->feature->id)
            ->update(['value' => $finalValue]);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Característica actualizada correctamente.'
        ]);

        $this->redirect(ProductResource::getUrl('features', ['record' => $this->product]));
    }
}