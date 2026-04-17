<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use App\Models\Product;
use App\Models\Feature;
use Filament\Resources\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\DB;

class AttachProductFeatures extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = ProductResource::class;

    protected string $view = 'filament.resources.products.pages.attach-product-features';

    public Product $record;

    public array $selectedFeatures = [];

    public function mount(Product $record): void
    {
        $this->record = $record;
    }

    public function getFormSchema(): array
    {
        $alreadyAssigned = $this->record->features()->pluck('features.id')->toArray();

        return [
            Select::make('selectedFeatures')
                ->label('Características a agregar')
                ->options(function () use ($alreadyAssigned) {
                    return Feature::query()
                        ->whereNotIn('id', $alreadyAssigned)
                        ->orderBy('group')
                        ->orderBy('name')
                        ->get()
                        ->mapWithKeys(function ($feature) {
                            $display = $feature->group 
                                ? "{$feature->group} → {$feature->name}" 
                                : $feature->name;
                            return [$feature->id => $display];
                        });
                })
                ->multiple()
                ->searchable()
                ->preload()
                ->required()
                ->columnSpanFull(),
        ];
    }

    public function attach(): void
    {
        if (empty($this->selectedFeatures)) {
            return;
        }

        foreach ($this->selectedFeatures as $featureId) {
            if (!$this->record->features()->where('feature_id', $featureId)->exists()) {
                $this->record->features()->attach($featureId, [
                    'value' => null,
                    'sort_order' => 0,
                ]);
            }
        }

        $this->redirect(ProductResource::getUrl('features', ['record' => $this->record]));
    }

    public function cancel(): void
    {
        $this->redirect(ProductResource::getUrl('features', ['record' => $this->record]));
    }
}