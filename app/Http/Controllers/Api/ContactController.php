<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BbbEmpresa;
use App\Mail\ContactNotification;
use App\Mail\CustomerContactConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Send contact form email
     */
    public function sendContact(Request $request)
    {
        try {
            // Validar los datos del formulario
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|min:2',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'country' => 'required|string|max:100',
                'plan' => 'nullable|string|max:100',
                'plan_nombre' => 'nullable|string|max:255',
                'message' => 'required|string|max:2000|min:10',
                'empresa_id' => 'nullable|integer|exists:bbbempresa,idEmpresa',
                'locale' => 'nullable|string|in:es,en'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Datos de formulario inválidos',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = $validator->validated();
            $locale = $data['locale'] ?? 'es'; // Default to Spanish
            
            // Obtener datos de la empresa (usar empresa_id del request o empresa por defecto)
            $empresaId = $data['empresa_id'] ?? 1;
            $empresa = BbbEmpresa::find($empresaId);
            
            // Si no se encuentra la empresa, crear un objeto por defecto
            if (!$empresa) {
                $empresa = (object) [
                    'idEmpresa' => $empresaId,
                    'nombre' => 'Empresa',
                    'email' => config('mail.from.address'),
                    'direccion' => null,
                    'movil' => null
                ];
            }

            
            
            Mail::to(config('app.support.email'))
            ->send(new ContactNotification($data, $empresa, $locale));

            // Enviar email al cliente usando Mailable
            Mail::to($data['email'], $data['name'])
            ->send(new CustomerContactConfirmation($data, $empresa, $locale));

            return response()->json([
                'success' => true,
                'message' => $locale === 'en' 
                    ? 'Message sent successfully. We will contact you soon.'
                    : 'Mensaje enviado correctamente. Pronto nos pondremos en contacto contigo.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error sending contact email: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Hubo un error al enviar el mensaje. Por favor intenta nuevamente. ' . $e->getMessage()
            ], 500);
        }
    }
}