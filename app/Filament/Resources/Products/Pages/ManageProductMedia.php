<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use App\Models\Product;
use Filament\Resources\Pages\Page;
use Filament\Forms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\FileUpload;

class ManageProductMedia extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = ProductResource::class;

    protected string $view = 'filament.resources.products.pages.manage-product-media';

    public Product $record;

    public function mount(Product $record): void
    {
        $this->record = $record;
        $this->form->fill($this->record->toArray());
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make('Banners')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            FileUpload::make('banner_pc')
                                ->label('Banner PC (Escritorio)')
                                ->image()
                                ->directory('products/banners')
                                ->disk('public')
                                ->imagePreviewHeight('180px')
                                ->maxSize(2048)
                                ->helperText('Recomendado: ancho grande'),

                            FileUpload::make('banner_mobile')
                                ->label('Banner Móvil')
                                ->image()
                                ->directory('products/banners')
                                ->disk('public')
                                ->imagePreviewHeight('180px')
                                ->maxSize(2048)
                                ->helperText('Recomendado: formato móvil'),
                        ]),
                ]),

            Section::make('Imagen Principal (Cover)')
                ->schema([
                    FileUpload::make('cover_image')
                        ->label('Imagen Cover')
                        ->image()
                        ->directory('products/covers')
                        ->disk('public')
                        ->imagePreviewHeight('220px')
                        ->maxSize(2048)
                        ->helperText('Tamaño recomendado: 384px x 600px'),
                ]),

            Section::make('Documento Técnico')
                ->schema([
                    FileUpload::make('technical_document')
                        ->label('Ficha Técnica (PDF)')
                        ->acceptedFileTypes(['application/pdf'])
                        ->directory('products/documents')
                        ->disk('public')
                        ->maxSize(5120)
                        ->downloadable()
                        ->helperText('Máximo 5MB - Solo PDF'),
                ]),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Actions\Action::make('save')
                ->label('Guardar cambios')
                ->color('success')
                ->submit('save'),

            Actions\Action::make('back')
                ->label('← Volver al Producto')
                ->url(fn () => ProductResource::getUrl('edit', ['record' => $this->record]))
                ->color('gray'),
        ];
    }

    public function save()
    {
        $this->record->update($this->form->getState());

        \Filament\Notifications\Notification::make()
            ->title('Imágenes y banners guardados correctamente')
            ->success()
            ->send();
    }
}