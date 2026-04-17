<?php

namespace App\Filament\Resources\Products\RelationManagers;

use App\Models\Feature;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
// use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\CheckboxList;
use Illuminate\Support\Facades\DB;

class FeaturesRelationManager extends RelationManager
{
    protected static string $relationship = 'features';

    protected static ?string $title = 'Características';

    protected static ?string $pluralModelLabel = 'Características';

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('feature_id')
                    ->label('Característica')
                    ->options(function () {
                        return Feature::query()
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
                    ->preload()
                    ->disabled()
                    ->columnSpanFull(),

                CheckboxList::make('value')
                    ->label('Opciones')
                    ->options(function (callable $get) {
                        $featureId = $get('feature_id');
                        if (!$featureId) return [];

                        $feature = Feature::with('options')->find($featureId);
                        if (!$feature || $feature->type !== 'select') return [];

                        return $feature->options->pluck('value', 'value')->toArray();
                    })
                    ->visible(fn (callable $get) => 
                        Feature::find($get('feature_id'))?->type === 'select'
                    )
                    ->gridDirection('row')
                    ->columns(3)
                    ->columnSpanFull(),

                TextInput::make('value')
                    ->label('Valor')
                    ->placeholder('Ej: 1.94 m, 60 cm, etc.')
                    ->maxLength(255)
                    ->visible(fn (callable $get) => 
                        Feature::find($get('feature_id'))?->type !== 'select'
                    )
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('group')
                    ->label('Grupo')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Característica')
                    ->weight('bold')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('pivot.value')
                    ->label('Valor asignado')
                    ->placeholder('—')
                    ->wrap()
                    ->searchable(),

                // Orden editable - Usamos nombre real de columna (sin 'pivot.')
                Tables\Columns\TextInputColumn::make('sort_order')
                    ->label('Orden')
                    ->type('number')
                    ->sortable()
                    ->rules(['integer', 'min:0'])
                    ->updateStateUsing(function ($record, $state) {
                        DB::table('product_features')
                            ->where('product_id', $this->ownerRecord->id)
                            ->where('feature_id', $record->id)
                            ->update(['sort_order' => (int) $state]);
                    }),
            ])
            ->defaultSort('sort_order', 'asc')   // ← Sin 'pivot.'
            ->headerActions([
                AttachAction::make()
                    ->label('Adjuntar característica')
                    ->preloadRecordSelect()
                    ->multiple(),
            ])
            ->actions([
                EditAction::make()
                    ->fillForm(function ($record) {
                        return [
                            'feature_id' => $record->id,
                            'value'      => $record->pivot->value ?? '',
                        ];
                    })
                    ->using(function ($record, array $data) {
                        DB::table('product_features')
                            ->where('product_id', $this->ownerRecord->id)
                            ->where('feature_id', $record->id)
                            ->update([
                                'value' => $data['value'] ?? null,
                            ]);
                    })
                    ->after(function () {
                        $this->dispatch('refresh-table');
                    }),

                DetachAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}