<?php

namespace App\Filament\Resources\Categories\Pages;

use App\Filament\Resources\Categories\CategoryResource;
use App\Models\Category;
use App\Models\Feature;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Actions;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\DB;

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
            ->query($this->getFeaturesQuery())
            ->columns($this->getTableColumns())
            ->defaultSort('sort_order', 'asc')
            ->actions($this->getTableActions())
            ->headerActions($this->getTableHeaderActions());
    }

    // ====================== QUERIES ======================
    protected function getFeaturesQuery()
    {
        return Feature::query()
            ->join('category_feature', 'features.id', '=', 'category_feature.feature_id')
            ->where('category_feature.category_id', $this->record->id)
            ->select('features.*', 'category_feature.sort_order as sort_order')
            ->orderBy('category_feature.sort_order');
    }

    // ====================== COLUMNAS ======================
    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('group')
                ->label('Grupo')
                ->badge()
                ->color('info'),

            TextColumn::make('name')
                ->label('Nombre del Filtro')
                ->weight('bold')
                ->searchable(),

            TextInputColumn::make('sort_order')
                ->label('Orden')
                ->type('number')
                ->sortable()
                ->alignCenter()
                ->rules(['required', 'numeric', 'min:0'])
                ->updateStateUsing(function (Feature $record, $state) {
                    DB::table('category_feature')
                        ->where('category_id', $this->record->id)
                        ->where('feature_id', $record->id)
                        ->update(['sort_order' => (int) $state]);
                })
                ->afterStateUpdated(fn () => $this->dispatch('refresh-table')),
        ];
    }

    // ====================== ACCIONES ======================
    protected function getTableActions(): array
    {
        return [
            Actions\EditAction::make()
                ->form($this->getEditFormSchema())
                ->using(function (Feature $record, array $data) {
                    $record->update(['group' => $data['group']]);

                    DB::table('category_feature')
                        ->where('category_id', $this->record->id)
                        ->where('feature_id', $record->id)
                        ->update(['sort_order' => (int) $data['sort_order']]);
                })
                ->after(fn () => $this->dispatch('refresh-table')),

            Actions\DeleteAction::make(),
        ];
    }

    protected function getEditFormSchema(): array
    {
        return [
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
        ];
    }

    // ====================== HEADER ACTIONS ======================
    protected function getTableHeaderActions(): array
    {
        return [
            Actions\Action::make('addFilter')
                ->label('Agregar Nuevo Filtro')
                ->icon('heroicon-o-plus')
                ->color('success')
                ->form($this->getAddFilterFormSchema())
                ->action(function (array $data) {
                    $this->record->features()->attach($data['feature_id'], [
                        'sort_order' => (int) $data['sort_order'],
                        'is_filter' => true,
                        'show_in_specs' => true,
                    ]);

                    $this->dispatch('refresh-table');
                }),
        ];
    }

    protected function getAddFilterFormSchema(): array
    {
        return [
            Select::make('feature_id')
                ->label('Seleccionar Filtro')
                ->options(function () {
                    $alreadyAssigned = $this->record->features()->pluck('features.id')->toArray();

                    return Feature::query()
                        ->where('type', 'select')
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
                ->required()
                ->searchable()
                ->preload(),

            TextInput::make('sort_order')
                ->label('Orden')
                ->numeric()
                ->minValue(0)
                ->default(0)
                ->required(),
        ];
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