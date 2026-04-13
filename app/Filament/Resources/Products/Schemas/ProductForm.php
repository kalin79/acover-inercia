<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('category_id')
                    ->required()
                    ->numeric(),
                TextInput::make('titulo')
                    ->required(),
                TextInput::make('subtitulo'),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('descripcion')
                    ->columnSpanFull(),
            ]);
    }
}
