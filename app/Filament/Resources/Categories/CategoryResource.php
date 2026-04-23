<?php

namespace App\Filament\Resources\Categories;

use App\Models\Category;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

// Schemas
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

// Forms Components
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;

// ==================== PARA LA TABLA ====================
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

// Actions
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;

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
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Textarea::make('descripcion')
                            ->label('Descripción')
                            ->rows(4),
                    ]),

                Section::make('Imágenes de Banner')
                    ->schema([
                        FileUpload::make('banner_pc')
                            ->label('Banner para PC (Desktop)')
                            ->image()
                            ->directory('categories/banners')
                            ->disk('public')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->columnSpan(1),

                        FileUpload::make('banner_mobile')
                            ->label('Banner para Móvil')
                            ->image()
                            ->directory('categories/banners')
                            ->disk('public')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->columnSpan(1),
                    ])
                    ->columns(2),

                Section::make('Secciones de la Categoría')
                    ->description('Gestiona las diferentes partes de esta categoría')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                \Filament\Actions\Action::make('manageFilters')
                                    ->label('Gestionar Filtros')
                                    ->icon(Heroicon::AdjustmentsHorizontal)
                                    ->color('warning')
                                    ->url(fn (?Category $record) => $record?->exists 
                                        ? CategoryResource::getUrl('filters', ['record' => $record]) 
                                        : null
                                    )
                                    ->visible(fn ($livewire) => method_exists($livewire, 'getRecord') && $livewire->getRecord()?->exists)
                                    ->disabled(fn ($livewire) => !($livewire instanceof \Filament\Resources\Pages\EditRecord))
                                    ->extraAttributes([
                                        'class' => 'h-32 flex flex-col items-center justify-center gap-3 text-center hover:scale-105 transition-transform border border-dashed'
                                    ]),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpanFull(),
            ]);
    }

   public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('titulo')
                ->label('Nombre')
                ->searchable()
                ->sortable()
                ->weight('bold'),

            TextColumn::make('slug')
                ->label('Slug')
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('descripcion')
                ->label('Descripción')
                ->limit(60)
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->defaultSort('titulo', 'asc')
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
            'index'   => Pages\ListCategories::route('/'),
            'create'  => Pages\CreateCategory::route('/create'),
            'edit'    => Pages\EditCategory::route('/{record}/edit'),
            'filters' => Pages\ManageCategoryFilters::route('/{record}/filters'),
        ];
    }
}