<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\CotizacionMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CotizacionController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|min:2|max:100',
            'company'     => 'nullable|string|max:150',
            'document'    => 'required|string|min:8|max:20',
            'email'       => 'required|email|max:150',
            'phone'       => 'required|string|min:9|max:15',
            'acceptTerms' => 'required|boolean|accepted',
            'context_title' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        try {
            Mail::to('ventas@acover.com.pe')
                ->cc('vicman.corzo@gmail.com')           // Copia visible (cámbialo si quieres)
                ->bcc(['c.augusto.espinoza@gmail.com'])         // Copia oculta
                ->send(new CotizacionMail($data));

            Log::info('Cotización enviada correctamente', $data);

            return response()->json([
                'success' => true,
                'message' => '¡Cotización enviada correctamente! Nos contactaremos pronto.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error enviando cotización: ' . $e->getMessage(), $data);

            return response()->json([
                'success' => false,
                'message' => 'Hubo un problema al enviar tu cotización. Inténtalo nuevamente.'
            ], 500);
        }
    }
}