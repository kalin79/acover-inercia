<x-filament-panels::page>
    <div style="max-width: 1000px; margin: 0 auto; padding: 30px 20px;">
        <p style="margin-bottom: 30px;">Producto: <strong>{{ $this->record->titulo ?? 'Sin título' }}</strong></p>

        <form wire:submit="save" style="background: white; padding: 45px; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.08);">

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 35px; margin-bottom: 50px;">
                
                <!-- Banner PC -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 10px;">Banner PC (Escritorio)</label>
                    <input type="file" wire:model="banner_pc" style="width: 100%; padding: 12px; border: 2px dashed #9ca3af; border-radius: 12px;">
                    @if($this->record->banner_pc)
                        <div style="margin-top: 12px;">
                            <img src="{{ Storage::url($this->record->banner_pc) }}" 
                                 style="max-width: 100%; border-radius: 8px; border: 1px solid #e5e7eb;" alt="Banner PC">
                        </div>
                    @endif
                </div>

                <!-- Banner Mobile -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 10px;">Banner Móvil</label>
                    <input type="file" wire:model="banner_mobile" style="width: 100%; padding: 12px; border: 2px dashed #9ca3af; border-radius: 12px;">
                    @if($this->record->banner_mobile)
                        <div style="margin-top: 12px;">
                            <img src="{{ Storage::url($this->record->banner_mobile) }}" 
                                 style="max-width: 100%; border-radius: 8px; border: 1px solid #e5e7eb;" alt="Banner Mobile">
                        </div>
                    @endif
                </div>

                <!-- Cover Image -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 10px;">Imagen Cover</label>
                    <input type="file" wire:model="cover_image" style="width: 100%; padding: 12px; border: 2px dashed #9ca3af; border-radius: 12px;">
                    @if($this->record->cover_image)
                        <div style="margin-top: 12px;">
                            <img src="{{ Storage::url($this->record->cover_image) }}" 
                                 style="max-width: 100%; border-radius: 8px; border: 1px solid #e5e7eb;" alt="Cover">
                        </div>
                    @endif
                </div>

                <!-- Technical Document -->
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 10px;">Ficha Técnica (PDF)</label>
                    <input type="file" wire:model="technical_document" accept=".pdf" style="width: 100%; padding: 12px; border: 2px dashed #9ca3af; border-radius: 12px;">
                    @if($this->record->technical_document)
                        <p style="margin-top: 12px; color: #16a34a;">✓ Archivo actual: {{ basename($this->record->technical_document) }}</p>
                    @endif
                </div>
            </div>

            <div style="margin-top: 50px; display: flex; justify-content: flex-end; gap: 15px;">
                <button 
                    type="button"
                    wire:click="cancel"
                    style="padding: 14px 32px; border: 2px solid #9ca3af; color: #4b5563; border-radius: 12px; background: white;">
                    Cancelar
                </button>
                <button 
                    type="submit"
                    style="padding: 14px 38px; background: #16a34a; color: white; border: none; border-radius: 12px;">
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</x-filament-panels::page>