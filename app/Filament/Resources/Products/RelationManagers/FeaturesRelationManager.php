<?php

namespace App\Filament\Resources\Products\RelationManagers;

use App\Models\Feature;                    // ← Esta línea faltaba
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
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

class FeaturesRelationManager extends RelationManager
{
    protected static string $relationship = 'features';

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
                    ->live()
                    ->columnSpanFull(),

                CheckboxList::make('value')
                    ->label(
                        fn(callable $get) =>
                        Feature::find($get('feature_id'))?->name ?? 'Seleccionar opciones'
                    )
                    ->options(function (callable $get) {
                        $featureId = $get('feature_id');
                        if (!$featureId)
                            return [];

                        $feature = Feature::with('options')->find($featureId);
                        if (!$feature || $feature->type !== 'select') {
                            return [];
                        }

                        return $feature->options->pluck('value', 'value');
                    })
                    ->visible(
                        fn(callable $get) =>
                        Feature::find($get('feature_id'))?->type === 'select'
                    )
                    ->gridDirection('row')
                    ->columns(3)
                    ->columnSpanFull(),

                TextInput::make('value')
                    ->label('Valor')
                    ->placeholder('Ej: 1.94 m, Rojo mate, 4 puertas')
                    ->maxLength(255)
                    ->visible(
                        fn(callable $get) =>
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
                    ->label('Valor / Opciones')
                    ->placeholder('—')
                    ->wrap()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('group', 'asc')
            ->headerActions([
                AttachAction::make()
                    ->label('Adjuntar característica')
                    ->preloadRecordSelect()
                    ->multiple(),
                CreateAction::make()
                    ->label('Nueva característica'),
            ])
            ->actions([
                EditAction::make(),
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