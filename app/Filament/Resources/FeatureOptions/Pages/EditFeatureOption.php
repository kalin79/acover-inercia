<?php

namespace App\Filament\Resources\FeatureOptions\Pages;

use App\Filament\Resources\FeatureOptions\FeatureOptionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFeatureOption extends EditRecord
{
    protected static string $resource = FeatureOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
