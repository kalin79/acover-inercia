<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use App\Models\Product;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Storage;

class ManageProductMedia extends Page
{
    protected static string $resource = ProductResource::class;

    protected string $view = 'filament.resources.products.pages.manage-product-media';

    public Product $record;

    // Propiedades para los archivos subidos
    public $banner_pc;
    public $banner_mobile;
    public $cover_image;
    public $technical_document;

    public function mount(Product $record): void
    {
        $this->record = $record;
    }

    public function save(): void
    {
        $updateData = [];

        // Procesar cada archivo
        if ($this->banner_pc) {
            $updateData['banner_pc'] = $this->banner_pc->store('products/banners', 'public');
        }

        if ($this->banner_mobile) {
            $updateData['banner_mobile'] = $this->banner_mobile->store('products/banners', 'public');
        }

        if ($this->cover_image) {
            $updateData['cover_image'] = $this->cover_image->store('products/covers', 'public');
        }

        if ($this->technical_document) {
            $updateData['technical_document'] = $this->technical_document->store('products/documents', 'public');
        }

        // Actualizar solo los campos que se subieron
        if (!empty($updateData)) {
            $this->record->update($updateData);
        }

        \Filament\Notifications\Notification::make()
            ->title('Medios guardados correctamente')
            ->success()
            ->send();

        $this->redirect(ProductResource::getUrl('media', ['record' => $this->record]));
    }

    public function cancel(): void
    {
        $this->redirect(ProductResource::getUrl('edit', ['record' => $this->record]));
    }
}