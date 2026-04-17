<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use App\Models\Product;
use App\Models\Feature;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Actions;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Facades\DB;

class ManageProductFeatures extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = ProductResource::class;

    protected string $view = 'filament.resources.products.pages.manage-product-features';

    public Product $record;

    public function mount(Product $record): void
    {
        $this->record = $record;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Feature::query()
                    ->join('product_features', 'features.id', '=', 'product_features.feature_id')
                    ->where('product_features.product_id', $this->record->id)
                    ->select([
                        'features.*',
                        'product_features.value as pivot_value',
                        'product_features.sort_order as pivot_sort_order'
                    ])
                    ->orderBy('product_features.sort_order')
            )
            ->columns([
                TextColumn::make('group')
                    ->label('Grupo')
                    ->badge()
                    ->color('info'),

                TextColumn::make('name')
                    ->label('Característica')
                    ->weight('bold')
                    ->searchable(),

                TextColumn::make('pivot_value')
                    ->label('Valor asignado')
                    ->placeholder('—')
                    ->wrap()
                    ->searchable(),

                TextInputColumn::make('pivot_sort_order')
                    ->label('Orden')
                    ->type('number')
                    ->sortable()
                    ->rules(['integer', 'min:0'])
                    ->updateStateUsing(function ($record, $state) {
                        DB::table('product_features')
                            ->where('product_id', $this->record->id)
                            ->where('feature_id', $record->id)
                            ->update(['sort_order' => (int) $state]);
                    }),
            ])
            ->defaultSort('pivot_sort_order', 'asc')
            ->headerActions([
                Actions\Action::make('addFeature')
                    ->label('Agregar Característica')
                    ->icon('heroicon-o-plus')
                    ->color('success')
                    ->url(fn () => ProductResource::getUrl('attach-features', ['record' => $this->record])),
            ])
            ->actions([
                Actions\Action::make('editFeature')
                    ->label('Editar')
                    ->icon('heroicon-o-pencil')
                    ->color('warning')
                    ->url(fn ($record) => "/acover-admin/products/{$this->record->id}/features/{$record->id}/edit"),

                // Reemplazamos DetachAction por acción manual
                Actions\Action::make('detach')
                    ->label('Eliminar')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        DB::table('product_features')
                            ->where('product_id', $this->record->id)
                            ->where('feature_id', $record->id)
                            ->delete();

                        $this->dispatch('refresh-table');
                    }),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('← Volver al Producto')
                ->url(fn () => ProductResource::getUrl('edit', ['record' => $this->record]))
                ->color('gray'),
        ];
    }
}