<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected array $featuresData = [];

    // ✅ AQUÍ VA
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->featuresData = $data['features'] ?? [];

        unset($data['features']);

        return $data;
    }

    // ✅ Y ESTE TAMBIÉN
    protected function afterCreate(): void
    {
        foreach ($this->featuresData as $featureId => $value) {

            if (!$value)
                continue;

            $feature = \App\Models\Feature::find($featureId);

            if ($feature->type === 'select') {
                $this->record->features()->attach($featureId, [
                    'feature_option_id' => $value
                ]);
            } else {
                $this->record->features()->attach($featureId, [
                    'value' => $value
                ]);
            }
        }
    }
}