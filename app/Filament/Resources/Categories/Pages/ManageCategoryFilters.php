<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoryResource;
use App\Models\Category;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions;
use Filament\Tables\Concerns\InteractsWithTable;   // ← Importante
use Filament\Tables\Contracts\HasTable;             // ← Importante
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\DB;


use App\Models\Feature;


class ManageCategoryFilters extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = CategoryResource::class;

    protected string $view = 'filament.resources.categories.pages.manage-category-filters';

    public Category $record;

    public function mount(Category $record): void
    {
        $this->record = $record;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Feature::query()
                    ->join('category_feature', 'features.id', '=', 'category_feature.feature_id')
                    ->where('category_feature.category_id', $this->record->id)
                    ->select('features.*', 'category_feature.sort_order as sort_order')
                    ->orderBy('category_feature.sort_order')
            )
            ->columns([
                TextColumn::make('group')
                    ->label('Grupo')
                    ->badge()
                    ->color('info'),

                TextColumn::make('name')
                    ->label('Nombre del Filtro')
                    ->weight('bold')
                    ->searchable(),

                \Filament\Tables\Columns\TextInputColumn::make('sort_order')
                    ->label('Orden')
                    ->type('number')
                    ->sortable()
                    ->alignCenter()
                    ->rules(['required', 'numeric', 'min:0'])
                    ->updateStateUsing(function (Feature $record, $state) {
                        \DB::table('category_feature')
                            ->where('category_id', $this->record->id)
                            ->where('feature_id', $record->id)
                            ->update(['sort_order' => (int) $state]);
                    })
                    ->afterStateUpdated(function () {
                        $this->dispatch('refresh-table');
                    }),
            ])
            ->defaultSort('sort_order', 'asc')
            ->actions([
                Actions\EditAction::make()
                    ->form([
                        // ← GRUPO como SELECT (solo los grupos existentes)
                        Select::make('group')
                            ->label('Grupo')
                            ->options(function () {
                                return Feature::query()
                                    ->where('type', 'select')
                                    ->distinct()
                                    ->pluck('group', 'group')
                                    ->toArray();
                            })
                            ->required()
                            ->searchable(),

                        TextInput::make('sort_order')
                            ->label('Orden')
                            ->numeric()
                            ->minValue(0)
                            ->required(),
                    ])
                    ->using(function (Feature $record, array $data) {
                        // Actualiza el Feature
                        $record->update([
                            'group' => $data['group'],
                        ]);

                        // Actualiza el orden en la tabla pivote
                        DB::table('category_feature')
                            ->where('category_id', $this->record->id)
                            ->where('feature_id', $record->id)
                            ->update(['sort_order' => (int) $data['sort_order']]);
                    })
                    ->after(function () {
                        $this->dispatch('refresh-table');
                    }),

                Actions\DeleteAction::make(),
            ])
            ->headerActions([
                Actions\Action::make('addFilter')
                    ->label('Agregar Nuevo Filtro')
                    ->icon('heroicon-o-plus')
                    ->color('success')
                    ->url(fn() => route('filament.admin.resources.features.create')),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('← Volver a la Categoría')
                ->url(fn() => CategoryResource::getUrl('edit', ['record' => $this->record]))
                ->color('gray'),
        ];
    }
}