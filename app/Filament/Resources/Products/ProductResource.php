<?php

namespace App\Filament\Resources\Products;

use App\Models\Product;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

// Actions
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;

// Schema Components
use Filament\Schemas\Components\Section;

// Form Components
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;

// Tables
use Filament\Tables;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::ShoppingBag;
    protected static string|\UnitEnum|null $navigationGroup = 'Catálogo';
    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'titulo';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Información Básica')
                    ->schema([
                        Select::make('category_id')
                            ->label('Categoría')
                            ->relationship('category', 'titulo')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),

                        TextInput::make('titulo')
                            ->label('Título')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, $set) => $set('slug', \Illuminate\Support\Str::slug($state)))
                            ->columnSpanFull(),

                        TextInput::make('subtitulo')
                            ->label('Subtítulo')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpanFull(),

                        RichEditor::make('descripcion')
                            ->label('Descripción del producto')
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'strike',
                                'h2', 'h3', 'bulletList', 'orderedList',
                                'link', 'undo', 'redo', 'blockquote', 'codeBlock',
                            ])
                            ->extraInputAttributes(['style' => 'min-height: 150px;'])
                            ->placeholder('Escribe aquí la descripción detallada del producto...')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),

                // Galería de Medios
                Section::make('Galería de Medios (Imágenes, Videos y YouTube)')
                    ->schema([
                        Repeater::make('media')
                            ->relationship('media')
                            ->label('Elementos de la galería')
                            ->schema([
                                Select::make('type')
                                    ->label('Tipo de medio')
                                    ->options([
                                        'image'   => '🖼️ Imagen',
                                        'video'   => '🎥 Video MP4',
                                        'youtube' => '▶️ Video de YouTube',
                                    ])
                                    ->required()
                                    ->live()
                                    ->default('image'),

                                FileUpload::make('file_path')
                                    ->label('Subir Archivo')
                                    ->disk('public')
                                    ->directory('products/gallery')
                                    ->maxSize(20480)
                                    ->visible(fn ($get) => in_array($get('type'), ['image', 'video']))
                                    ->imagePreviewHeight('180px')
                                    ->helperText(fn ($get) => $get('type') === 'video' ? 'Solo archivos MP4' : 'Imágenes y videos'),

                                TextInput::make('youtube_url')
                                    ->label('Código de YouTube')
                                    ->placeholder('Ej: dQw4w9wgxcq')
                                    ->visible(fn ($get) => $get('type') === 'youtube')
                                    ->columnSpanFull(),

                                TextInput::make('sort_order')
                                    ->label('Orden')
                                    ->numeric()
                                    ->default(0),
                            ])
                            ->columnSpanFull()
                            ->reorderable()
                            ->addActionLabel('Agregar nuevo elemento a la galería')
                            ->defaultItems(0)
                            ->collapsible(),
                    ])
                    ->columnSpanFull(),

                // Sección para gestionar Banners, Cover y PDF
               // Sección para gestionar Banners, Cover y PDF
                Section::make('Imágenes, Banners y Documento Técnico')
                    ->description('Gestiona los banners, imagen principal y ficha técnica')
                    ->schema([
                        \Filament\Actions\Action::make('manageMedia')
                            ->label('Gestionar Banners, Cover y PDF')
                            ->icon('heroicon-o-photo')
                            ->color('warning')
                            ->size('lg')
                            ->url(fn (?Product $record) => $record?->exists 
                                ? ProductResource::getUrl('media', ['record' => $record]) 
                                : '#'
                            )
                           ->visible(fn ($livewire) => method_exists($livewire, 'getRecord') && $livewire->getRecord()?->exists)
                    ])
                    ->columnSpanFull(),

                // Sección para gestionar Características
                Section::make('Características del Producto')
                    ->description('Gestiona las características y sus valores')
                    ->schema([
                        \Filament\Actions\Action::make('manageFeatures')
                            ->label('Gestionar Características')
                            ->icon('heroicon-o-adjustments-horizontal')
                            ->color('warning')
                            ->size('lg')
                            ->url(fn (?Product $record) => $record?->exists 
                                ? ProductResource::getUrl('features', ['record' => $record]) 
                                : '#'
                            )
                           ->visible(fn ($livewire) => method_exists($livewire, 'getRecord') && $livewire->getRecord()?->exists)
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo')
                    ->label('Producto')
                    ->weight('bold')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('subtitulo')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('slug')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('technical_document')
                    ->label('Documento')
                    ->formatStateUsing(fn($state) => $state ? '✓ PDF' : '—')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'           => Pages\ListProducts::route('/'),
            'create'          => Pages\CreateProduct::route('/create'),
            'edit'            => Pages\EditProduct::route('/{record}/edit'),
            'features'        => Pages\ManageProductFeatures::route('/{record}/features'),
            'feature-edit'    => Pages\EditProductFeature::route('/{record}/features/{feature}/edit'),
            'attach-features' => Pages\AttachProductFeatures::route('/{record}/attach-features'),
            'media'           => Pages\ManageProductMedia::route('/{record}/media'),   // ← Página de medios
        ];
    }
}