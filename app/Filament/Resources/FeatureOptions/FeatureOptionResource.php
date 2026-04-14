<?php

namespace App\Filament\Resources\FeatureOptions;

use App\Models\FeatureOption;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

use Filament\Tables;
use Filament\Tables\Table;

use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;

class FeatureOptionResource extends Resource
{
    protected static ?string $model = FeatureOption::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::ListBullet;

    protected static string|\UnitEnum|null $navigationGroup = 'Catálogo';

    protected static ?int $navigationSort = 5;

    // 🧠 FORM
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Opción')
                    ->schema([

                        Select::make('feature_id')
                            ->label('Característica')
                            ->relationship('feature', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('value')
                            ->label('Valor')
                            ->required()
                            ->placeholder('Ej: Rojo, Azul, Metal'),
                        TextInput::make('codigo')
                            ->label('Código interno (opcional)')
                            ->placeholder('#f00')
                            ->maxLength(50)
                            ->nullable(),

                    ])
            ]);
    }

    // 📊 TABLE
    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('feature.name')
                    ->label('Característica')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('value')
                    ->label('Valor')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFeatureOptions::route('/'),
            'create' => Pages\CreateFeatureOption::route('/create'),
            'edit' => Pages\EditFeatureOption::route('/{record}/edit'),
        ];
    }
}