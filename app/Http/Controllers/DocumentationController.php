<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentationController extends Controller
{
    /**
     * Mostrar la página principal de documentación
     */
    public function index()
    {
        $user = Auth::user();
        
        return view('documentation.index', compact('user'));
    }

    /**
     * Mostrar guía de inicio rápido
     */
    public function quickStart()
    {
        $user = Auth::user();
        
        return view('documentation.quick-start', compact('user'));
    }

    /**
     * Mostrar guía para publicar web
     */
    public function publishGuide()
    {
        $user = Auth::user();
        
        return view('documentation.publish-guide', compact('user'));
    }

    /**
     * Mostrar guía de configuración de perfil
     */
    public function profileGuide()
    {
        $user = Auth::user();
        
        return view('documentation.profile-guide', compact('user'));
    }

    /**
     * Mostrar guía de planes y suscripciones
     */
    public function plansGuide()
    {
        $user = Auth::user();
        
        return view('documentation.plans-guide', compact('user'));
    }

    /**
     * Mostrar guía de landing pages
     */
    public function landingGuide()
    {
        $user = Auth::user();
        
        return view('documentation.landing-guide', compact('user'));
    }

    /**
     * Mostrar guía de configuración de landing
     */
    public function landingConfigurationGuide()
    {
        $user = Auth::user();
        
        return view('documentation.landing-configuration-guide', compact('user'));
    }

    /**
     * Mostrar guía de gestión de clientes
     */
    public function clientsGuide()
    {
        $user = Auth::user();
        
        return view('documentation.clients-guide', compact('user'));
    }

    /**
     * Mostrar preguntas frecuentes
     */
    public function faq()
    {
        $user = Auth::user();
        
        return view('documentation.faq', compact('user'));
    }

    /**
     * Mostrar guía de recibos y pagos
     */
    public function receiptsGuide()
    {
        $user = Auth::user();
        
        return view('documentation.receipts-guide', compact('user'));
    }

    /**
     * Mostrar guía de arquitectura del proyecto
     */
    public function architecture()
    {
        $user = Auth::user();
        
        return view('documentation.architecture', compact('user'));
    }

    /**
     * Mostrar guía de productos
     */
    public function productsGuide()
    {
        $user = Auth::user();
        
        return view('documentation.products-guide', compact('user'));
    }

    /**
     * Mostrar guía de ventas online
     */
    public function salesGuide()
    {
        $user = Auth::user();
        
        return view('documentation.sales-guide', compact('user'));
    }

    /**
     * Mostrar guía de configuración de pagos
     */
    public function paymentsGuide()
    {
        $user = Auth::user();
        
        return view('documentation.payments-guide', compact('user'));
    }
}