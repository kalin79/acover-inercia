<?php

namespace App\Filament\Resources\Products;

use App\Models\Product;
use App\Filament\Resources\Products\RelationManagers\FeaturesRelationManager;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

// Actions
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;

// Schema Components (Filament v5)
use Filament\Schemas\Components\Section;
// Form Components (la mayoría siguen aquí en v5)
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
// use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;

// Get correcto para Filament v5
use Filament\Schemas\Components\Utilities\Get as SchemaGet;

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
                            ->columnSpanFull(),   // ← Ocupa todo el ancho

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
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'h2',
                                'h3',
                                'bulletList',
                                'orderedList',
                                'link',
                                'undo',
                                'redo',
                                'blockquote',
                                'codeBlock',
                            ])
                            ->extraInputAttributes(['style' => 'min-height: 150px;'])
                            ->placeholder('Escribe aquí la descripción detallada del producto...')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),   // ← Esto hace que toda la sección ocupe el 100%
                Section::make('Imágenes y Banners')
                    ->schema([
                        FileUpload::make('banner_pc')
                            ->label('Banner PC (Escritorio)')
                            ->image()
                            ->directory('products/banners')
                            ->disk('public')                      // ← Forzar disco public
                            ->imagePreviewHeight('120px')
                            ->maxSize(2048)           // 2MB
                            ->columnSpan(1),

                        FileUpload::make('banner_mobile')
                            ->label('Banner Móvil')
                            ->image()
                            ->directory('products/banners')
                            ->imagePreviewHeight('120px')
                            ->disk('public')                      // ← Forzar disco public
                            ->maxSize(2048)
                            ->columnSpan(1),

                        FileUpload::make('cover_image')
                            ->label('Imagen Cover (Principal)')
                            ->disk('public')                      // ← Forzar disco public
                            ->image()
                            ->directory('products/covers')
                            ->helperText('Tamaño: 384px x 600px')
                            ->maxSize(2048)
                            ->columnSpanFull(),

                        FileUpload::make('technical_document')
                            ->label('Documento Técnico / Ficha (PDF)')
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('products/documents')
                            ->disk('public')
                            ->maxSize(5120) // 5MB
                            ->downloadable()
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make('Galería de Medios (Imágenes, Videos y YouTube)')
                    ->schema([
                        Repeater::make('media')
                            ->relationship('media')
                            ->label('Elementos de la galería')
                            ->schema([
                                Select::make('type')
                                    ->label('Tipo de medio')
                                    ->options([
                                        'image' => '🖼️ Imagen',
                                        'video' => '🎥 Video MP4',
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
                                    ->rules([])
                                    ->previewable()
                                    ->imagePreviewHeight('180px')
                                    ->visible(fn(SchemaGet $get) => in_array($get('type'), ['image', 'video']))
                                    ->helperText(fn(SchemaGet $get) => $get('type') === 'video' ? 'Solo archivos MP4' : 'Imágenes y videos'),

                                TextInput::make('youtube_url')
                                    ->label('YouTube')
                                    ->placeholder('Código del video')
                                    ->visible(fn(SchemaGet $get) => $get('type') === 'youtube')
                                    ->helperText('Ejemplo: dQw4w9wgxcq'),

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
                    ]),

            ]);
    }

    // ... el resto de tu código (table, getRelations, getPages) se mantiene igual
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

                // Nuevo campo: Documento Técnico
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
        return [
            FeaturesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}