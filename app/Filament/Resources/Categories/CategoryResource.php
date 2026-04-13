<?php

namespace App\Filament\Resources\Categories;

use App\Models\Category;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

// Actions
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;

// Components
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
// use Filament\Forms\Components\Toggle;
// use Filament\Forms\Components\Repeater;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::Folder;

    protected static string|\UnitEnum|null $navigationGroup = 'Catálogo';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'titulo';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Información de la Categoría')
                    ->schema([
                        TextInput::make('titulo')
                            ->label('Título')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, $set) => $set('slug', \Illuminate\Support\Str::slug($state))),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Textarea::make('descripcion')
                            ->label('Descripción')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Imágenes de Banner')
                    ->schema([
                        FileUpload::make('banner_pc')
                            ->label('Banner para PC (Desktop)')
                            ->disk('public')
                            ->directory('categories/banners')
                            ->maxSize(8192)
                            ->rules([])                    // Acepta todo
                            ->previewable()
                            ->imagePreviewHeight('220px')
                            ->helperText('Tamaño: 2160px x 213px'),

                        FileUpload::make('banner_mobile')
                            ->label('Banner para Móvil')
                            ->disk('public')
                            ->directory('categories/banners')
                            ->maxSize(8192)
                            ->rules([])                    // Acepta todo
                            ->previewable()
                            ->imagePreviewHeight('220px')
                            ->helperText('Tamaño: 2160px x 213px'),
                    ])
                    ->columns(2),

                Section::make('Características y Filtros')
                    ->schema([
                        Select::make('features')
                            ->label('Características asignadas')
                            ->relationship(
                                name: 'features',           // nombre de la relación en el modelo Category
                                titleAttribute: 'name',
                                modifyQueryUsing: fn($query) =>
                                $query->where('type', '!=', 'text')   // ← Aquí está el filtro
                            )
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('titulo')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                \Filament\Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->toggleable(isToggledHiddenByDefault: true),

                \Filament\Tables\Columns\TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(60)
                    ->toggleable(isToggledHiddenByDefault: true),

                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}