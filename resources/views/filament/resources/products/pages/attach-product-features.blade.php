<x-filament-panels::page>
    <div style="max-width: 800px; margin: 0 auto; padding: 20px 0;">
        
        <!-- Header -->
        <div style="margin-bottom: 40px; text-align: center;">
            <p style="font-size: 20px; color: #4b5563; margin-top: 8px;">
                Producto: <strong style="color: #1f2937;">{{ $this->record->titulo ?? 'Sin nombre' }}</strong>
            </p>
        </div>

        <form wire:submit="attach" style="background: white; border-radius: 16px; box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1); padding: 40px;">

            {{ $this->form }}

            <!-- Botones -->
            <div style="display: flex; justify-content: flex-end; gap: 16px; margin-top: 40px; padding-top: 30px; border-top: 1px solid #e5e7eb;">
                <button 
                    type="button"
                    wire:click="cancel"
                    style="padding: 14px 32px; border: 2px solid #9ca3af; color: #4b5563; border-radius: 12px; font-weight: 600; background: white; cursor: pointer; font-size: 16px;">
                    Cancelar
                </button>
                
                <button 
                    type="submit"
                    style="padding: 14px 36px; background: #16a34a; color: white; border: none; border-radius: 12px; font-weight: 600; cursor: pointer; font-size: 16px; display: flex; align-items: center; gap: 10px;">
                    <span>Agregar Características</span>
                </button>
            </div>
        </form>
    </div>
</x-filament-panels::page>