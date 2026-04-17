<x-filament-panels::page>
    <div style="max-width: 800px; margin: 0 auto; padding: 20px 0;">
        
        <!-- Header -->
        <div style="margin-bottom: 30px;">
            <p style="font-size: 20px; color: #4b5563; margin: 8px 0 0 0;">
                {{ $this->feature->name }}
                @if($this->feature->group)
                    <span style="margin-left: 12px; font-size: 14px; font-weight: 600; background: #dbeafe; color: #1e40af; padding: 4px 12px; border-radius: 9999px;">
                        {{ $this->feature->group }}
                    </span>
                @endif
            </p>
        </div>

        <form wire:submit="save" style="background: white; border-radius: 16px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); padding: 40px;">

            @if($this->feature->type === 'select')
                <div style="margin-bottom: 30px;">
                    <label style="display: block; font-size: 17px; font-weight: 600; color: #374151; margin-bottom: 18px;">
                        Selecciona las opciones que apliquen:
                    </label>

                    @php
                        $pivot = DB::table('product_features')
                            ->where('product_id', $this->product->id)
                            ->where('feature_id', $this->feature->id)
                            ->first();

                        $currentValue = $pivot?->value ?? null;
                        $selected = $currentValue 
                            ? (is_string($currentValue) ? json_decode($currentValue, true) : (array)$currentValue) 
                            : [];

                        $selected = array_map('trim', array_filter((array)$selected));
                    @endphp

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px;">
                        @foreach($this->feature->options as $option)
                            <label style="display: flex; align-items: center; gap: 14px; padding: 18px; border: 2px solid #e5e7eb; border-radius: 12px; cursor: pointer; transition: all 0.2s;">
                                <input 
                                    type="checkbox"
                                    value="{{ $option->value }}"
                                    wire:model.live="value"
                                    {{ in_array(trim($option->value), $selected) ? 'checked' : '' }}
                                    style="width: 22px; height: 22px; accent-color: #3b82f6;"
                                >
                                <span style="font-size: 16px; color: #1f2937; font-weight: 500;">
                                    {{ $option->value }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @else
                <!-- Tipo texto -->
                <div>
                    <label style="display: block; font-size: 17px; font-weight: 600; color: #374151; margin-bottom: 10px;">
                        Valor
                    </label>
                    <input 
                        type="text" 
                        wire:model="value"
                        placeholder="Ingrese el valor..."
                        style="width: 100%; padding: 16px 20px; border: 2px solid #d1d5db; border-radius: 12px; font-size: 16px; outline: none;"
                        onfocus="this.style.borderColor='#3b82f6'"
                    >
                </div>
            @endif

            <!-- Botones -->
            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 40px; padding-top: 24px; border-top: 1px solid #e5e7eb;">
                <button 
                    type="button"
                    wire:click="cancel"
                    style="padding: 12px 28px; border: 2px solid #9ca3af; color: #4b5563; border-radius: 10px; font-weight: 600; cursor: pointer; background: white;">
                    Cancelar
                </button>
                
                <button 
                    type="submit"
                    style="padding: 12px 32px; background: #16a34a; color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                    <span>Guardar cambios</span>
                </button>
            </div>
        </form>
    </div>
</x-filament-panels::page>