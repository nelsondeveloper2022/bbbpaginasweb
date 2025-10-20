<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BbbPlan;
use App\Models\BbbEmpresa;
use App\Mail\ContactNotification;
use App\Mail\CustomerContactConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

/**
 * LandingController - Maneja todas las páginas de la landing page
 * Controla las diferentes secciones: inicio, servicios, testimonios, contacto, etc.
 */
class LandingController extends Controller
{
    /**
     * Página de inicio con hero section y todas las secciones principales
     */
    public function index()
    {
        // Obtener los planes para mostrar en la sección de planes del home
        $plans = BbbPlan::where('idEmpresa', 1)
        ->where('idioma', 'spanish')
        ->orderBy('orden')
        ->get();
        
        return view('landing.index', compact('plans'));
    }

    /**
     * Página "Sobre Nosotros" / About
     */
    public function about()
    {
        return view('landing.about');
    }

    /**
     * Página de servicios detallados
     */
    public function services()
    {
        return view('landing.services');
    }

    /**
     * Página de testimonios de clientes
     */
    public function testimonials()
    {
        return view('landing.testimonials');
    }

    /**
     * Página de contacto con formulario
     */
    public function contact()
    {
        $plans = BbbPlan::where('idEmpresa', 1)
                        ->where('idioma', 'spanish')
                        ->orderBy('orden')
                        ->get();
                        
        return view('landing.contact', compact('plans'));
    }

    /**
     * Página de planes con datos de la base de datos
     */
    public function plans()
    {
        $plans = BbbPlan::where('idEmpresa', 1)
                        ->where('idioma', 'spanish')
                        ->orderBy('orden')
                        ->get();
                        
        return view('landing.plans', compact('plans'));
    }

    /**
     * Página genérica para contenido legal (términos, privacidad, cookies)
     */
    public function legalPage($type)
    {
        $empresa = BbbEmpresa::find(1);
        
        // Mapear el tipo a los campos de la base de datos (solo español)
        $fieldMap = [
            'terms' => 'terminos_condiciones',
            'privacy' => 'politica_privacidad',
            'cookies' => 'politica_cookies'
        ];
        
        // Mapear títulos y descripciones
        $pageInfo = [
            'terms' => [
                'title' => 'Términos y Condiciones - BBB Páginas Web',
                'description' => 'Términos y condiciones de uso de los servicios de BBB Páginas Web.',
                'hero_title' => 'Términos y Condiciones',
                'hero_subtitle' => 'Conoce las condiciones de uso de nuestros servicios'
            ],
            'privacy' => [
                'title' => 'Política de Privacidad - BBB Páginas Web',
                'description' => 'Política de privacidad de BBB Páginas Web. Conoce cómo protegemos tu información.',
                'hero_title' => 'Política de Privacidad',
                'hero_subtitle' => 'Tu privacidad es importante para nosotros'
            ],
            'cookies' => [
                'title' => 'Política de Cookies - BBB Páginas Web',
                'description' => 'Política de cookies de BBB Páginas Web. Conoce cómo utilizamos las cookies.',
                'hero_title' => 'Política de Cookies',
                'hero_subtitle' => 'Información sobre el uso de cookies en nuestro sitio web'
            ]
        ];
        
        $content = $empresa->{$fieldMap[$type]} ?? null;
        $info = $pageInfo[$type];
        
        return view('landing.legal', compact('empresa', 'content', 'info'));
    }

    /**
     * Página de términos y condiciones
     */
    public function terms()
    {
        return $this->legalPage('terms');
    }

    /**
     * Página de política de privacidad
     */
    public function privacy()
    {
        return $this->legalPage('privacy');
    }

    /**
     * Página de política de cookies
     */
    public function cookies()
    {
        return $this->legalPage('cookies');
    }

    /**
     * Procesamiento del formulario de contacto
     */
    public function sendContact(Request $request)
    {
        try {
            // Validación del formulario
            $validated = $request->validate([
                'name' => 'required|string|max:255|min:2',
                'email' => 'required|email|max:255',
                'phone' => 'nullable|string|max:20',
                'country' => 'required|string|max:100',
                'plan' => 'nullable|string|max:100',
                'project_description' => 'required|string|max:2000|min:10',
                'empresa_id' => 'nullable|integer|exists:bbbempresa,idEmpresa'
            ]);

            // Detect locale from session, request or use default - fixed to Spanish
            $locale = 'es';

            // Preparar datos para compatibilidad con Mailables
            $customerData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'country' => $validated['country'],
                'plan' => $validated['plan'] ?? null,
                'message' => $validated['project_description'],
            ];

            // Obtener datos de la empresa (usar empresa_id del request o empresa por defecto)
            $empresaId = $validated['empresa_id'] ?? 1;
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

            // Enviar email al cliente usando Mailable
            Mail::to($customerData['email'], $customerData['name'])
                ->send(new CustomerContactConfirmation($customerData, $empresa, $locale));

            Mail::to($empresa->email, $empresa->nombre ?? 'Empresa')
            ->send(new ContactNotification($customerData, $empresa, $locale));
            

            $successMessage = '¡Mensaje enviado exitosamente! Te contactaremos pronto.';

            return redirect()->route('contact')->with('success', $successMessage);

        } catch (\Exception $e) {
            Log::error('Error sending contact email: ' . $e->getMessage());
            
            $errorMessage = 'Hubo un error al enviar el mensaje. Por favor intenta nuevamente. Error: ' . $e->getMessage();

            return redirect()->route('contact')->with('error', $errorMessage);
        }
    }
}