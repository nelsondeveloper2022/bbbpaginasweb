<?php

namespace App\Http\Controllers;

use App\Models\BbbEmpresa;
use App\Models\BbbLanding;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;

class PublicLandingController extends Controller
{
    /**
     * Display the landing page for a specific company slug.
     */
    public function showLanding(Request $request, string $slug): View|Response
    {
        // Find the company by slug
        $empresa = BbbEmpresa::where('slug', $slug)->first();
        
        if (!$empresa) {
            abort(404, 'Landing page not found');
        }

        // Check the landing status
        $estadoLanding = $empresa->estado ?? 'sin_configurar';
        
        // Handle different states
        switch ($estadoLanding) {
            case 'en_construccion':
                return $this->showConstructionPage($empresa);
            
            case 'vencida':
                return $this->showExpiredPage($empresa);
            
            case 'publicada':
                break; // Continue to show the landing
            
            case 'sin_configurar':
            default:
                return $this->showBasicLanding($empresa);
        }

        // Get the landing configuration for published state
        $landing = $empresa->landing;
        
        if (!$landing) {
            return $this->showBasicLanding($empresa);
        }

        // Load media relations
        $landing->load(['media', 'images', 'icons']);

        // Check if custom view exists
        $customViewPath = 'landings.' . $slug . '.index';
        
        if (view()->exists($customViewPath)) {
            
            // Use custom view if it exists
            return view($customViewPath, compact('empresa', 'landing'));
        }

        // Fallback to default landing view
        return view('public.landing', compact('empresa', 'landing'));
    }

    /**
     * Show a basic landing page when no configuration exists.
     */
    private function showBasicLanding(BbbEmpresa $empresa): View
    {
        // Create a basic landing object with company info
        $landing = new BbbLanding([
            'titulo_principal' => $empresa->nombre,
            'descripcion' => 'Bienvenido a ' . $empresa->nombre,
            'color_principal' => '#007bff',
            'color_secundario' => '#6c757d',
            'tipografia' => 'Inter'
        ]);
        
        // Set empty relations to avoid errors
        $landing->setRelation('media', collect());
        $landing->setRelation('images', collect());
        $landing->setRelation('icons', collect());

        return view('public.basic-landing', compact('empresa', 'landing'));
    }

    /**
     * Show construction page when landing is being configured.
     */
    private function showConstructionPage(BbbEmpresa $empresa): View
    {
        return view('public.construction', compact('empresa'));
    }

    /**
     * Show expired page when landing has expired.
     */
    private function showExpiredPage(BbbEmpresa $empresa): View
    {
        return view('public.expired', compact('empresa'));
    }

    /**
     * Get company info API endpoint (optional for AJAX calls).
     */
    public function getCompanyInfo(string $slug)
    {
        $empresa = BbbEmpresa::where('slug', $slug)
            ->with(['landing', 'landing.media'])
            ->first();
        
        if (!$empresa) {
            return response()->json(['error' => 'Company not found'], 404);
        }

        return response()->json([
            'empresa' => [
                'nombre' => $empresa->nombre,
                'email' => $empresa->email,
                'movil' => $empresa->movil,
                'direccion' => $empresa->direccion,
                'website' => $empresa->website,
                'facebook' => $empresa->facebook,
                'instagram' => $empresa->instagram,
                'linkedin' => $empresa->linkedin,
                'twitter' => $empresa->twitter,
                'tiktok' => $empresa->tiktok,
                'youtube' => $empresa->youtube,
                'whatsapp' => $empresa->whatsapp,
            ],
            'landing' => $empresa->landing ? [
                'titulo_principal' => $empresa->landing->titulo_principal,
                'subtitulo' => $empresa->landing->subtitulo,
                'descripcion' => $empresa->landing->descripcion,
                'objetivo' => $empresa->landing->objetivo,
                'descripcion_objetivo' => $empresa->landing->descripcion_objetivo,
                'audiencia_descripcion' => $empresa->landing->audiencia_descripcion,
                'audiencia_problemas' => $empresa->landing->audiencia_problemas,
                'audiencia_beneficios' => $empresa->landing->audiencia_beneficios,
                'color_principal' => $empresa->landing->color_principal,
                'color_secundario' => $empresa->landing->color_secundario,
                'estilo' => $empresa->landing->estilo,
                'tipografia' => $empresa->landing->tipografia,
                'logo_url' => $empresa->landing->logo_url ? asset('storage/' . $empresa->landing->logo_url) : null,
                'media' => $empresa->landing->media->map(function($media) {
                    return [
                        'tipo' => $media->tipo,
                        'url' => asset('storage/' . $media->url),
                        'descripcion' => $media->descripcion
                    ];
                })
            ] : null
        ]);
    }

    /**
     * Check if a slug is available.
     */
    public function checkSlugAvailability(Request $request)
    {
        $slug = $request->get('slug');
        
        if (!$slug) {
            return response()->json(['available' => false, 'message' => 'Slug is required']);
        }

        $exists = BbbEmpresa::where('slug', $slug)->exists();
        
        return response()->json([
            'available' => !$exists,
            'slug' => $slug,
            'message' => $exists ? 'This slug is already taken' : 'Slug is available'
        ]);
    }
}