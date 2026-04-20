@component('mail::message')

# Nueva Solicitud de Cotización
<div style="text-align: center; margin-bottom: 30px;">
    <img src="{{ asset('images/logo.svg') }}" 
         alt="Acover" 
         style="max-width: 240px; height: auto; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
</div>
@if (!empty($data['context_title']))
<p><strong>Producto:</strong> {{ $data['context_title'] }}</p>
@endif
<p><strong>Nombre:</strong> {{ $data['name'] }}</p>
<p><strong>Empresa:</strong> {{ $data['company'] ?? 'No especificada' }}</p>
<p><strong>Documento:</strong> {{ $data['document'] }}</p>
<p><strong>Correo:</strong> {{ $data['email'] }}</p>
<p><strong>Celular:</strong> {{ $data['phone'] }}</p

---

**Enviado desde el sitio web de Acover**

@endcomponent