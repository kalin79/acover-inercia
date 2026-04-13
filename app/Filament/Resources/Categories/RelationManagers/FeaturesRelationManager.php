<?php

namespace App\Filament\Resources\Categories\RelationManagers;

use App\Models\Feature;
use Filament\Actions\AttachAction;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;

class FeaturesRelationManager extends RelationManager
{
    protected static string $relationship = 'features';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('feature_id')
                    ->label('Característica')
                    ->options(Feature::all()->pluck('name', 'id'))
                    ->required()
                    ->searchable()
                    ->preload(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('group')
                    ->label('Grupo'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Característica'),
            ])
            ->headerActions([
                AttachAction::make()->label('Adjuntar característica'),
                CreateAction::make()->label('Nueva característica'),
            ]);
    }
}