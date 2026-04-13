<?php

namespace App\Filament\Resources\Features;

use App\Models\Feature;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class FeatureResource extends Resource
{
    protected static ?string $model = Feature::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::AdjustmentsHorizontal;

    protected static string|\UnitEnum|null $navigationGroup = 'Catálogo';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Característica')
                    ->schema([
                        TextInput::make('group')
                            ->label('Grupo')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('ej: dimensiones_generales, colores, materiales, seguridad'),

                        TextInput::make('name')
                            ->label('Nombre de la característica')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('ej: Alto, Ancho, Color, Cerradura, Peso')
                            ->rule('required'),   // Forzamos validación

                        Select::make('type')
                            ->label('Tipo de campo')
                            ->options([
                                'text' => 'Texto libre',
                                'select' => 'Lista de opciones',
                            ])
                            ->required()
                            ->default('text'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('group')
                    ->label('Grupo')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Característica')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('type')
                    ->label('Tipo')
                    ->badge(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('group', 'asc')
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeatures::route('/'),
            'create' => Pages\CreateFeature::route('/create'),
            'edit' => Pages\EditFeature::route('/{record}/edit'),
        ];
    }
}