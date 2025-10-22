<?php

namespace App\Http\Controllers;

use App\Models\BbbLanding;
use App\Models\BbbLandingMedia;
use App\Models\BbbEmpresa;
use App\Mail\LandingPublishedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class LandingConfigController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // El middleware ya está aplicado en las rutas
    }

    /**
     * Display the landing configuration form.
     */
    public function index()
    {
        $user = Auth::user();
        $empresa = BbbEmpresa::find($user->idEmpresa);
        $landing = BbbLanding::where('idEmpresa', $user->idEmpresa)->first();
        
        // Si no existe una landing, crear una nueva instancia vacía
        if (!$landing) {
            $landing = new BbbLanding();
            $landing->idEmpresa = $user->idEmpresa;
        }

        // Verificar si el perfil está completo
        $profileComplete = $user->hasCompleteProfile() && $user->isEmailVerified();
        $profileCompletion = $user->getProfileCompletion();
        $profileDetails = $user->getProfileCompletionDetails();

        $objetivoOptions = BbbLanding::getObjetivoOptions();
        $estiloOptions = BbbLanding::getEstiloOptions();
        $tipografiaOptions = BbbLanding::getTipografiaOptions();

        return view('landing.configurar_simple', compact(
            'empresa', 
            'landing', 
            'objetivoOptions', 
            'estiloOptions', 
            'tipografiaOptions',
            'profileComplete',
            'profileCompletion',
            'profileDetails'
        ));
    }

    /**
     * Store or update a landing page configuration (Simplified version).
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Verificar si el perfil está completo antes de procesar
        if (!$user->hasCompleteProfile() || !$user->isEmailVerified()) {
            return redirect()->route('admin.landing.configurar')
                ->with('error', 'Debes completar los datos de tu empresa antes de configurar la landing page.');
        }
        
        // Obtener la empresa
        $empresa = BbbEmpresa::find($user->idEmpresa);
        if(!$empresa) {
            $empresa = BbbEmpresa::where('nombre', $user->empresa_nombre)
                ->where('estado', null)
                ->first();
            
            if($empresa) {
                $user->idEmpresa = $empresa->idEmpresa;
                $user->save();
            }
        }
        
        if (!$empresa) {
            return redirect()->back()
                ->with('error', 'No se pudo encontrar la información de tu empresa.');
        }
        
        $isPublished = ($empresa->estado === 'publicada');
        
        // Verificar si ya existe una landing
        $landing = BbbLanding::where('idEmpresa', $user->idEmpresa)->first();
        
        // Validación simplificada para formulario básico
        $validationRules = [
            'empresa_nombre' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
            'titulo_principal' => 'required|string|max:255',
            'color_principal' => 'nullable|string|max:7',
            'color_secundario' => 'nullable|string|max:7',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
        ];
        
        // Solo validar logo si no está publicada o no existe uno
        if (!$isPublished) {
            $validationRules['logo'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048';
        }
        
        $request->validate($validationRules, [
            'empresa_nombre.required' => 'El nombre de la empresa es obligatorio.',
            'whatsapp.required' => 'El número de WhatsApp es obligatorio.',
            'titulo_principal.required' => 'El título principal es obligatorio.',
            'logo.image' => 'El logo debe ser una imagen válida.',
            'logo.mimes' => 'El logo debe ser JPG, PNG, GIF, SVG o WEBP.',
            'logo.max' => 'El logo no puede ser mayor a 2MB.',
            'facebook.url' => 'La URL de Facebook debe ser válida.',
            'instagram.url' => 'La URL de Instagram debe ser válida.',
            'twitter.url' => 'La URL de Twitter debe ser válida.',
        ]);

        try {
            // Actualizar empresa
            $empresa->nombre = $request->empresa_nombre;
            $empresa->whatsapp = $request->whatsapp;
            $empresa->facebook = $request->facebook;
            $empresa->instagram = $request->instagram;
            $empresa->twitter = $request->twitter;
            
            // Manejar logo si se subió uno nuevo
            if ($request->hasFile('logo')) {
                // Eliminar logo anterior si existe
                if ($empresa->logo && Storage::exists($empresa->logo)) {
                    Storage::delete($empresa->logo);
                }
                
                $logoPath = $request->file('logo')->store('logos', 'public');
                $empresa->logo = $logoPath;
            }
            
            $empresa->save();
            
            // Crear o actualizar landing
            if (!$landing) {
                $landing = new BbbLanding();
                $landing->idEmpresa = $user->idEmpresa;
            }
            
            $landing->titulo_principal = $request->titulo_principal;
            $landing->color_principal = $request->color_principal ?? '#007bff';
            $landing->color_secundario = $request->color_secundario ?? '#6c757d';
            
            // Solo actualizar estos campos si no está publicada
            if (!$isPublished) {
                $landing->objetivo = 'generar_contactos'; // Valor fijo para formulario básico
                $landing->subtitulo = $request->titulo_principal . ' - Contáctanos';
                $landing->descripcion = 'Empresa dedicada a brindar servicios de calidad. Contáctanos para más información.';
                $landing->estilo = 'moderno';
                $landing->tipografia = 'inter';
            }
            
            $landing->save();
            
            // Manejar imágenes adicionales si se subieron
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $mediaFile) {
                    $mediaPath = $mediaFile->store('landing-media', 'public');
                    
                    BbbLandingMedia::create([
                        'idLanding' => $landing->idLanding,
                        'tipo' => 'imagen',
                        'ruta' => $mediaPath,
                        'nombre_original' => $mediaFile->getClientOriginalName(),
                    ]);
                }
            }
            
            // Auto-publicar como se solicitó
            if (!$isPublished) {
                $empresa->estado = 'publicada';
                $empresa->fecha_publicacion = now();
                $empresa->save();
                
                $landing->estado = 'publicada';
                $landing->save();
                
                // Enviar notificación por email
                try {
                    Mail::to($user->email)->send(new LandingPublishedNotification($landing, $empresa));
                } catch (\Exception $e) {
                    Log::error('Error enviando email de landing publicada: ' . $e->getMessage());
                }
                
                return redirect()->route('admin.landing.configurar')
                    ->with('success', '¡Landing page guardada y publicada exitosamente! Recibirás un email con los detalles.');
            } else {
                return redirect()->route('admin.landing.configurar')
                    ->with('success', 'Landing page actualizada exitosamente.');
            }
            
        } catch (\Exception $e) {
            Log::error('Error guardando landing: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Hubo un error al guardar la configuración. Por favor intenta nuevamente.')
                ->withInput();
        }
    }
            $validationRules = array_merge($validationRules, [
                // Landing fields
                'objetivo' => 'required|string|max:200',
                'descripcion_objetivo' => 'nullable|string',
                'audiencia_descripcion' => 'nullable|string',
                'audiencia_problemas' => 'nullable|string',
                'audiencia_beneficios' => 'nullable|string',
                'color_principal' => 'nullable|string|max:50',
                'color_secundario' => 'nullable|string|max:50',
                'estilo' => 'nullable|string|max:100',
                'tipografia' => 'nullable|string|max:100',
                // Logo: solo requerido si no existe uno previamente
                'logo' => [
                    $tieneLogoExistente ? 'nullable' : 'required',
                    'image',
                    'mimes:jpeg,png,jpg,gif,svg,webp',
                    'max:2048'
                ],
                'titulo_principal' => 'required|string|max:255',
                'subtitulo' => 'nullable|string|max:255',
                'descripcion' => 'nullable|string',
                // Slug validation
                'slug' => [
                    'nullable',
                    'string',
                    'min:3',
                    'max:50',
                    'regex:/^[a-z0-9\-]+$/',
                    Rule::unique('bbbempresa', 'slug')->ignore($user->idEmpresa, 'idEmpresa')
                ],
            ]);
        }
        
        $validator = Validator::make($request->all(), $validationRules, [
            // Mensajes de validación personalizados en español
            'objetivo.required' => 'El objetivo de la landing page es obligatorio.',
            'objetivo.max' => 'El objetivo no puede tener más de 200 caracteres.',
            'titulo_principal.required' => 'El título principal es obligatorio.',
            'titulo_principal.max' => 'El título principal no puede tener más de 255 caracteres.',
            'subtitulo.max' => 'El subtítulo no puede tener más de 255 caracteres.',
            'empresa_nombre.required' => 'El nombre de la empresa es obligatorio.',
            'empresa_nombre.max' => 'El nombre de la empresa no puede tener más de 255 caracteres.',
            'empresa_email.email' => 'El email corporativo debe tener un formato válido.',
            'empresa_email.max' => 'El email corporativo no puede tener más de 255 caracteres.',
            'empresa_movil.max' => 'El teléfono móvil no puede tener más de 20 caracteres.',
            'whatsapp.required' => 'El número de WhatsApp es obligatorio.',
            'whatsapp.max' => 'El número de WhatsApp no puede tener más de 20 caracteres.',
            'website.max' => 'La URL del sitio web no puede tener más de 255 caracteres.',
            'facebook.url' => 'La URL de Facebook debe ser válida.',
            'facebook.max' => 'La URL de Facebook no puede tener más de 255 caracteres.',
            'instagram.url' => 'La URL de Instagram debe ser válida.',
            'instagram.max' => 'La URL de Instagram no puede tener más de 255 caracteres.',
            'linkedin.url' => 'La URL de LinkedIn debe ser válida.',
            'linkedin.max' => 'La URL de LinkedIn no puede tener más de 255 caracteres.',
            'twitter.url' => 'La URL de Twitter debe ser válida.',
            'twitter.max' => 'La URL de Twitter no puede tener más de 255 caracteres.',
            'tiktok.url' => 'La URL de TikTok debe ser válida.',
            'tiktok.max' => 'La URL de TikTok no puede tener más de 255 caracteres.',
            'youtube.url' => 'La URL de YouTube debe ser válida.',
            'youtube.max' => 'La URL de YouTube no puede tener más de 255 caracteres.',
            'color_principal.max' => 'El color principal no puede tener más de 50 caracteres.',
            'color_secundario.max' => 'El color secundario no puede tener más de 50 caracteres.',
            'estilo.max' => 'El estilo no puede tener más de 100 caracteres.',
            'tipografia.max' => 'La tipografía no puede tener más de 100 caracteres.',
            'logo.required' => 'El logo de la empresa es obligatorio.',
            'logo.image' => 'El logo debe ser una imagen válida.',
            'logo.mimes' => 'El logo debe ser un archivo de tipo: JPG, PNG, GIF, SVG o WEBP.',
            'logo.max' => 'El logo no puede ser mayor a 2MB.',
            'slug.min' => 'El slug debe tener al menos 3 caracteres.',
            'slug.max' => 'El slug no puede tener más de 50 caracteres.',
            'slug.regex' => 'El slug solo puede contener letras minúsculas, números y guiones.',
            'slug.unique' => 'Este slug ya está en uso por otra empresa.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Obtener la empresa del usuario
            $empresa = BbbEmpresa::find($user->idEmpresa);

            

            if($empresa == null){
                
                $empresa = BbbEmpresa::where('nombre', $user->empresa_nombre)
                ->where('estado' , null)
                ->first();

                if($empresa){
                    $user->idEmpresa = $empresa->idEmpresa;
                    $user->save();
                }
            }
            
            if (!$empresa) {
                return redirect()->back()
                    ->with('error', 'No se encontró la información de la empresa.')
                    ->withInput();
            }

            // Verificar el estado de la landing
            $estadoLanding = $empresa->estado ?? 'sin_configurar';
            $isPublished = ($estadoLanding === 'publicada');

            // Solo actualizar información de la landing si NO está publicada
            if (!$isPublished) {
                // Manejar cambio de slug si es necesario
                $oldSlug = $empresa->slug;
                $newSlug = $request->slug;
                
                // Si se proporciona un nuevo slug y es diferente al actual
                if (!empty($newSlug) && $newSlug !== $oldSlug) {
                    // Validar que el nuevo slug esté disponible
                    $slugExists = BbbEmpresa::where('slug', $newSlug)
                        ->where('idEmpresa', '!=', $empresa->idEmpresa)
                        ->exists();
                    
                    if ($slugExists) {
                        return redirect()->back()
                            ->with('error', 'El dominio seleccionado ya está en uso. Por favor, elige otro.')
                            ->withInput();
                    }
                    
                    // Mover archivos de la carpeta anterior a la nueva
                    $this->moveCompanyFiles($empresa, $oldSlug, $newSlug);
                    
                    // Actualizar el slug en la empresa
                    $empresa->slug = $newSlug;
                } else {
                    // Generar/actualizar slug automáticamente si no se proporciona
                    $empresa->updateSlug();
                }
                
                $empresa->save();

                // Crear directorio de vistas para la landing
                $empresa->createLandingViews();
                $this->createLandingIndexView($empresa);

                // Buscar o crear la landing
                $landing = BbbLanding::where('idEmpresa', $user->idEmpresa)->first();
                
                if (!$landing) {
                    $landing = new BbbLanding();
                    $landing->idEmpresa = $user->idEmpresa;
                }

                // Actualizar los campos de la landing
                $landing->objetivo = $request->objetivo;
                $landing->descripcion_objetivo = $request->descripcion_objetivo;
                $landing->audiencia_descripcion = $request->audiencia_descripcion;
                $landing->audiencia_problemas = $request->audiencia_problemas;
                $landing->audiencia_beneficios = $request->audiencia_beneficios;
                $landing->color_principal = $request->color_principal;
                $landing->color_secundario = $request->color_secundario;
                $landing->estilo = $request->estilo;
                $landing->tipografia = $request->tipografia;
                $landing->titulo_principal = $request->titulo_principal;
                $landing->subtitulo = $request->subtitulo;
                $landing->descripcion = $request->descripcion;

                $landing->save();
            }

            // Buscar la landing existente para actualizar logo y archivos adicionales
            $landing = BbbLanding::where('idEmpresa', $user->idEmpresa)->first();
            
            if ($landing) {
                // Manejar la subida del logo usando el slug (permitido en todos los estados)
                if ($request->hasFile('logo')) {
                    // Eliminar el logo anterior si existe
                    if ($landing->logo_url) {
                        Storage::disk('public')->delete($landing->logo_url);
                    }

                    $logoPath = $request->file('logo')->store($empresa->getLandingStoragePath(), 'public');
                    $landing->logo_url = $logoPath;
                    $landing->save();
                }
            }

            // Actualizar información de la empresa
            $empresa->nombre = $request->empresa_nombre;
            $empresa->email = $request->empresa_email;
            $empresa->movil = $request->empresa_movil;
            $empresa->whatsapp = $request->whatsapp;
            $empresa->direccion = $request->empresa_direccion;
            $empresa->website = $request->website;
            $empresa->facebook = $request->facebook;
            $empresa->instagram = $request->instagram;
            $empresa->linkedin = $request->linkedin;
            $empresa->twitter = $request->twitter;
            $empresa->tiktok = $request->tiktok;
            $empresa->youtube = $request->youtube;
            $empresa->terminos_condiciones = $request->terminos_condiciones;
            $empresa->politica_privacidad = $request->politica_privacidad;
            $empresa->politica_cookies = $request->politica_cookies;
            
            // Actualizar slug solo si no está publicada
            if (!$isPublished && !empty($request->slug)) {
                $empresa->slug = $request->slug;
            }
            
            $empresa->save();

            // También actualizar campos del usuario para mantener consistencia
            $user->empresa_nombre = $request->empresa_nombre;
            $user->empresa_email = $request->empresa_email;
            $user->empresa_direccion = $request->empresa_direccion;
            $user->save();

            // Automaticamente publicar la landing si NO está ya publicada
            if (!$isPublished) {
                try {
                    // Obtener datos actualizados
                    $empresa = BbbEmpresa::find($user->idEmpresa);
                    $landing = BbbLanding::where('idEmpresa', $user->idEmpresa)->first();
                    
                    if ($empresa && $landing) {
                        // Generar/actualizar slug si es necesario
                        $empresa->updateSlug();

                        // Cambiar estado a "en construcción"
                        $empresa->setLandingUnderConstruction();

                        // Cargar relaciones necesarias (incluyendo imágenes adicionales del modelo BbbLandingMedia)
                        $landing->load(['media', 'images', 'icons']);

                        // Crear directorio de vistas y archivo index con todas las imágenes
                        $empresa->createLandingViews();
                        $this->createLandingIndexView($empresa);

                        // Enviar email de notificación
                        try {
                            Mail::to(config('app.support.email'))->send(new LandingPublishedNotification($empresa, $landing));
                        } catch (\Exception $e) {
                            // Log error but don't fail the process
                            Log::warning('Failed to send landing publication email: ' . $e->getMessage());
                        }

                        // Mensaje de éxito con publicación automática
                        return redirect()->route('admin.landing.configurar')
                            ->with('success', 'Configuración guardada y landing page publicada exitosamente.')
                            ->with('published', true)
                            ->with('landing_url', $empresa->getLandingUrl());
                    }
                } catch (\Exception $e) {
                    // Si falla la publicación, no falla todo el proceso
                    Log::warning('Failed to auto-publish landing: ' . $e->getMessage());
                    
                    return redirect()->route('admin.landing.configurar')
                        ->with('success', 'Configuración guardada exitosamente, pero hubo un problema al publicar automáticamente. Puedes publicar manualmente.')
                        ->with('warning', 'Error en publicación automática: ' . $e->getMessage());
                }
            }

            // Mensaje de éxito personalizado según lo que se guardó
            $successMessage = $isPublished 
                ? 'Información empresarial actualizada exitosamente. La configuración de la landing no se modificó porque está publicada.'
                : 'Configuración de landing e información empresarial guardada exitosamente.';

            return redirect()->route('admin.landing.configurar')
                ->with('success', $successMessage);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al guardar la configuración: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Update an existing landing page configuration.
     */
    public function update(Request $request, $id)
    {
        return $this->store($request);
    }

    /**
     * Remove the specified landing page configuration.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        
        try {
            $landing = BbbLanding::where('idEmpresa', $user->idEmpresa)->findOrFail($id);
            
            // Eliminar archivos asociados
            if ($landing->logo_url) {
                Storage::disk('public')->delete($landing->logo_url);
            }

            // Eliminar media asociados
            foreach ($landing->media as $media) {
                if ($media->url) {
                    Storage::disk('public')->delete($media->url);
                }
            }

            $landing->delete();

            return redirect()->route('admin.landing.configurar')
                ->with('success', 'Configuración de landing eliminada exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar la configuración: ' . $e->getMessage());
        }
    }

    /**
     * Handle media upload for landing page.
     */
    public function mediaStore(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make(
            $request->all(),
            [
                // Admite imágenes comunes; image valida tipo MIME imagen. Límite de 2MB
                'media' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'tipo' => 'required|in:imagen,icono',
                'descripcion' => 'nullable|string|max:255',
            ],
            [
                'media.required' => 'Debes seleccionar una imagen.',
                'media.image' => 'La imagen debe ser un archivo de imagen válido.',
                'media.mimes' => 'La imagen debe ser de tipo: JPG, PNG, GIF, SVG o WEBP.',
                'media.max' => 'La imagen debe ser máximo de 2MB.',
                'tipo.required' => 'El tipo de archivo es obligatorio.',
                'tipo.in' => 'El tipo de archivo es inválido.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Obtener o crear la landing automáticamente
            $landing = BbbLanding::where('idEmpresa', $user->idEmpresa)->first();
            
            if (!$landing) {
                // Obtener empresa
                $empresa = BbbEmpresa::find($user->idEmpresa);
                
                if (!$empresa) {
                    $empresa = BbbEmpresa::where('nombre', $user->empresa_nombre)
                        ->where('estado', null)
                        ->first();
                    
                    if ($empresa) {
                        $user->idEmpresa = $empresa->idEmpresa;
                        $user->save();
                    }
                }
                
                if (!$empresa) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No se encontró la información de la empresa.'
                    ], 400);
                }

                // Asegurar que la empresa tenga un slug
                if (!$empresa->slug) {
                    $empresa->updateSlug();
                    $empresa->save();
                }

                // Crear una landing básica automáticamente para permitir subir imágenes
                $landing = new BbbLanding();
                $landing->idEmpresa = $user->idEmpresa;
                $landing->titulo_principal = $empresa->nombre ?? 'Mi Empresa';
                $landing->objetivo = 'generar_contactos'; // Valor por defecto
                // No establecer estado ya que la columna no existe en la tabla
                $landing->save();
            } else {
                // Si la landing ya existe, obtener la empresa
                $empresa = BbbEmpresa::find($user->idEmpresa);
            }
            
            // Subir archivo en la ruta landing/media
            $mediaPath = $request->file('media')->store('landing/media', 'public');

            // Crear registro en la base de datos
            $media = new BbbLandingMedia();
            $media->idLanding = $landing->idLanding;
            $media->tipo = $request->tipo;
            $media->url = $mediaPath;
            $media->descripcion = $request->descripcion;
            $media->save();

            return response()->json([
                'success' => true,
                'media' => [
                    'id' => $media->idMedia,
                    'url' => $media->full_url,
                    'tipo' => $media->tipo,
                    'descripcion' => $media->descripcion
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al subir el archivo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove media from landing page.
     */
    public function mediaDestroy($id)
    {
        $user = Auth::user();
        
        try {
            $media = BbbLandingMedia::whereHas('landing', function($query) use ($user) {
                $query->where('idEmpresa', $user->idEmpresa);
            })->findOrFail($id);

            // Eliminar archivo del storage
            if ($media->url) {
                Storage::disk('public')->delete($media->url);
            }

            $media->delete();

            return response()->json([
                'success' => true,
                'message' => 'Archivo eliminado exitosamente.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el archivo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Preview the landing page configuration.
     */
    public function preview()
    {
        $user = Auth::user();
        $empresa = BbbEmpresa::find($user->idEmpresa);
        $landing = BbbLanding::where('idEmpresa', $user->idEmpresa)->first();
        
        if (!$landing || !$empresa) {
            return redirect()->route('admin.landing.configurar')
                ->with('error', 'Debe configurar su landing page primero.');
        }

        // Verificar que existe el slug de la empresa
        if (!$empresa->slug) {
            return redirect()->route('admin.landing.configurar')
                ->with('error', 'La empresa debe tener un slug configurado.');
        }

        // Verificar que existe la vista de la landing
        $viewName = "landings.{$empresa->slug}.index";

        
        if (!view()->exists($viewName)) {
            return redirect()->route('admin.landing.configurar')
                ->with('error', 'La vista de la landing page no existe. Publique primero su landing.');
        }

        // Retornar la vista específica de la empresa con los datos necesarios
        return view($viewName, compact('landing', 'empresa'));
    }

    /**
     * Get media files via AJAX.
     */
    public function getMedia()
    {
        $user = Auth::user();
        $landing = BbbLanding::where('idEmpresa', $user->idEmpresa)->first();
        
        if (!$landing) {
            return response()->json([
                'success' => false,
                'media' => []
            ]);
        }

        $media = $landing->media->map(function ($item) {
            return [
                'id' => $item->idMedia,
                'url' => $item->full_url,
                'tipo' => $item->tipo,
                'descripcion' => $item->descripcion
            ];
        });

        return response()->json([
            'success' => true,
            'media' => $media
        ]);
    }

    /**
     * Publish the landing page.
     */
    public function publish(Request $request)
    {
        $user = Auth::user();
        
        // Verificar si el perfil está completo antes de publicar
        if (!$user->hasCompleteProfile() || !$user->isEmailVerified()) {
            return redirect()->route('admin.landing.configurar')
                ->with('error', 'Debes completar tu perfil antes de publicar tu landing page.')
                ->withInput();
        }
        
        try {
            $empresa = BbbEmpresa::find($user->idEmpresa);
            $landing = BbbLanding::where('idEmpresa', $user->idEmpresa)->first();
            
            if (!$empresa) {
                return redirect()->back()
                    ->with('error', 'No se encontró la información de la empresa.');
            }

            if (!$landing) {
                return redirect()->back()
                    ->with('error', 'Debe configurar su landing page antes de publicar.');
            }

            // Generar/actualizar slug si es necesario
            $empresa->updateSlug();

            // Cambiar estado a "en construcción"
            $empresa->setLandingUnderConstruction();

            // Cargar relaciones necesarias (incluyendo imágenes adicionales del modelo BbbLandingMedia)
            $landing->load(['media', 'images', 'icons']);

            // Crear directorio de vistas y archivo index con todas las imágenes
            $empresa->createLandingViews();
            $this->createLandingIndexView($empresa);

            // Enviar email de notificación
            try {
                Mail::to(config('app.support.email'))->send(new LandingPublishedNotification($empresa, $landing));
            } catch (\Exception $e) {
                // Log error but don't fail the publication
                Log::warning('Failed to send landing publication email: ' . $e->getMessage());
            }

            return redirect()->route('admin.landing.configurar')
                ->with('success', 'Tu landing page se ha publicado exitosamente y está en construcción.')
                ->with('published', true)
                ->with('landing_url', $empresa->getLandingUrl());

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al publicar la landing page: ' . $e->getMessage());
        }
    }

    /**
     * Get landing summary for construction view.
     */
    public function getSummary()
    {
        $user = Auth::user();
        $empresa = BbbEmpresa::find($user->idEmpresa);
        $landing = BbbLanding::where('idEmpresa', $user->idEmpresa)->with(['media', 'images', 'icons'])->first();

        if (!$empresa || !$landing) {
            return redirect()->route('admin.landing.configurar')
                ->with('error', 'No se encontró información de la landing page.');
        }

        return response()->json([
            'empresa' => $empresa,
            'landing' => $landing,
            'landing_url' => $empresa->getLandingUrl(),
            'estado' => $empresa->estado
        ]);
    }

    /**
     * Create the landing index view file for a company.
     */
    private function createLandingIndexView($empresa)
    {
        $viewPath = $empresa->getLandingViewsPath();
        $indexFile = $viewPath . '/index.blade.php';

        // Only create if it doesn't exist
        if (!file_exists($indexFile)) {
            $viewContent = $this->getLandingViewTemplate();
            file_put_contents($indexFile, $viewContent);
        }
    }

    /**
     * Move company files from old slug folder to new slug folder.
     */
    private function moveCompanyFiles($empresa, $oldSlug, $newSlug)
    {
        if (empty($oldSlug) || $oldSlug === $newSlug) {
            return;
        }

        try {
            // Mover archivos de storage (imágenes, logos, etc.)
            $oldStoragePath = 'landing/' . $oldSlug;
            $newStoragePath = 'landing/' . $newSlug;
            
            if (Storage::disk('public')->exists($oldStoragePath)) {
                // Crear la nueva carpeta
                Storage::disk('public')->makeDirectory($newStoragePath);
                
                // Obtener todos los archivos de la carpeta antigua
                $files = Storage::disk('public')->allFiles($oldStoragePath);
                
                foreach ($files as $file) {
                    $filename = basename($file);
                    $newFilePath = $newStoragePath . '/' . $filename;
                    
                    // Mover el archivo
                    Storage::disk('public')->move($file, $newFilePath);
                }
                
                // Eliminar la carpeta antigua si está vacía
                if (empty(Storage::disk('public')->allFiles($oldStoragePath))) {
                    Storage::disk('public')->deleteDirectory($oldStoragePath);
                }
                
                // Actualizar las URLs en la base de datos
                $landing = $empresa->landing;
                if ($landing) {
                    // Actualizar logo principal
                    if ($landing->logo_url) {
                        $landing->logo_url = str_replace($oldStoragePath, $newStoragePath, $landing->logo_url);
                        $landing->save();
                    }
                    
                    // Actualizar URLs en la tabla bbb_landing_media
                    $mediaFiles = BbbLandingMedia::where('idLanding', $landing->idLanding)->get();
                    foreach ($mediaFiles as $media) {
                        if ($media->url && strpos($media->url, $oldStoragePath) !== false) {
                            $media->url = str_replace($oldStoragePath, $newStoragePath, $media->url);
                            $media->save();
                        }
                    }
                    
                    Log::info("Updated {$mediaFiles->count()} media file URLs from {$oldSlug} to {$newSlug}");
                }
            }

            // Mover vistas (carpeta en resources/views/landings/)
            $oldViewsPath = resource_path('views/landings/' . $oldSlug);
            $newViewsPath = resource_path('views/landings/' . $newSlug);
            
            if (is_dir($oldViewsPath)) {
                // Crear la nueva carpeta
                if (!is_dir($newViewsPath)) {
                    mkdir($newViewsPath, 0755, true);
                }
                
                // Mover archivos de vistas
                $viewFiles = glob($oldViewsPath . '/*');
                foreach ($viewFiles as $file) {
                    $filename = basename($file);
                    $newFile = $newViewsPath . '/' . $filename;
                    rename($file, $newFile);
                }
                
                // Eliminar la carpeta antigua si está vacía
                if (count(glob($oldViewsPath . '/*')) === 0) {
                    rmdir($oldViewsPath);
                }
            }

            Log::info("Company files moved successfully from {$oldSlug} to {$newSlug}");

        } catch (\Exception $e) {
            Log::error("Error moving company files: " . $e->getMessage());
            // No lanzar excepción para no interrumpir el proceso principal
        }
    }

    /**
     * Get the template content for landing index view.
     */
    private function getLandingViewTemplate()
    {
        return <<<'BLADE'
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $landing->titulo_principal ?? $empresa->nombre }} - {{ $empresa->nombre }}</title>
    <meta name="description" content="{{ $landing->descripcion ?? 'Bienvenido a ' . $empresa->nombre }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:title" content="{{ $landing->titulo_principal ?? $empresa->nombre }}">
    <meta property="og:description" content="{{ $landing->descripcion ?? 'Bienvenido a ' . $empresa->nombre }}">
    @if($landing->logo_url)
        <meta property="og:image" content="{{ asset('storage/' . $landing->logo_url) }}">
    @endif

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ request()->url() }}">
    <meta property="twitter:title" content="{{ $landing->titulo_principal ?? $empresa->nombre }}">
    <meta property="twitter:description" content="{{ $landing->descripcion ?? 'Bienvenido a ' . $empresa->nombre }}">
    @if($landing->logo_url)
        <meta property="twitter:image" content="{{ asset('storage/' . $landing->logo_url) }}">
    @endif

    <!-- Favicon -->
    @if($landing->logo_url)
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $landing->logo_url) }}">
    @endif
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    @if($landing->tipografia)
        <link href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $landing->tipografia) }}:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @endif
    
    <style>
        :root {
            --color-primary: {{ $landing->color_principal ?: '#007bff' }};
            --color-secondary: {{ $landing->color_secundario ?: '#6c757d' }};
            --font-family: {{ $landing->tipografia ? "'".$landing->tipografia."', " : '' }}system-ui, -apple-system, sans-serif;
        }
        
        body {
            font-family: var(--font-family);
            line-height: 1.6;
        }
        
        .btn-primary {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
        }
        
        .btn-primary:hover {
            background-color: color-mix(in srgb, var(--color-primary) 85%, black);
            border-color: color-mix(in srgb, var(--color-primary) 85%, black);
        }
        
        .text-primary {
            color: var(--color-primary) !important;
        }
        
        .bg-primary {
            background-color: var(--color-primary) !important;
        }
        
        .text-secondary {
            color: var(--color-secondary) !important;
        }
        
        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--color-primary) 0%, color-mix(in srgb, var(--color-primary) 80%, black) 100%);
        }
        
        .hero-content {
            color: white;
        }
        
        .logo-container {
            max-width: 200px;
            margin-bottom: 2rem;
        }
        
        .feature-card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }
        
        .media-gallery img {
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        @media (max-width: 768px) {
            .hero-section {
                min-height: 80vh;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        @if($landing->logo_url)
                            <div class="logo-container">
                                <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="Logo {{ $empresa->nombre }}" class="img-fluid">
                            </div>
                        @endif
                        
                        @if($landing->titulo_principal)
                            <h1 class="display-4 fw-bold mb-4">{{ $landing->titulo_principal }}</h1>
                        @else
                            <h1 class="display-4 fw-bold mb-4">Bienvenido a {{ $empresa->nombre }}</h1>
                        @endif
                        
                        @if($landing->subtitulo)
                            <h2 class="h4 mb-4 opacity-90">{{ $landing->subtitulo }}</h2>
                        @endif
                        
                        @if($landing->descripcion)
                            <p class="lead mb-5 opacity-90">{{ $landing->descripcion }}</p>
                        @endif
                        
                        <div class="d-flex flex-column flex-sm-row gap-3">
                            <a href="#contacto" class="btn btn-light btn-lg px-4">
                                @switch($landing->objetivo)
                                    @case('vender_producto')
                                        <i class="bi bi-cart-plus me-2"></i>Comprar Ahora
                                        @break
                                    @case('captar_leads')
                                        <i class="bi bi-envelope me-2"></i>Obtener Información
                                        @break
                                    @case('reservas')
                                        <i class="bi bi-calendar-check me-2"></i>Hacer Reserva
                                        @break
                                    @case('descargas')
                                        <i class="bi bi-download me-2"></i>Descargar Gratis
                                        @break
                                    @default
                                        <i class="bi bi-arrow-right me-2"></i>Comenzar
                                @endswitch
                            </a>
                            @if($empresa->whatsapp)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $empresa->whatsapp) }}" 
                                   class="btn btn-outline-light btn-lg px-4" 
                                   target="_blank">
                                    <i class="bi bi-whatsapp me-2"></i>WhatsApp
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                
                @if($landing->images->count() > 0)
                    <div class="col-lg-6">
                        <div class="text-center">
                            <img src="{{ asset('storage/' . $landing->images->first()->url) }}" 
                                 alt="Imagen principal" 
                                 class="img-fluid rounded shadow-lg"
                                 style="max-height: 400px;">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Features Section -->
    @if($landing->audiencia_problemas || $landing->audiencia_beneficios)
        <section class="py-5">
            <div class="container">
                <div class="row">
                    @if($landing->audiencia_problemas)
                        <div class="col-lg-6 mb-4">
                            <div class="card feature-card h-100">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-danger bg-opacity-10 rounded-circle p-3 me-3">
                                            <i class="bi bi-exclamation-triangle text-danger"></i>
                                        </div>
                                        <h3 class="h5 mb-0">Problemas que Resolvemos</h3>
                                    </div>
                                    <p class="text-muted mb-0">{{ $landing->audiencia_problemas }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if($landing->audiencia_beneficios)
                        <div class="col-lg-6 mb-4">
                            <div class="card feature-card h-100">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                            <i class="bi bi-check-circle text-success"></i>
                                        </div>
                                        <h3 class="h5 mb-0">Beneficios que Obtienes</h3>
                                    </div>
                                    <p class="text-muted mb-0">{{ $landing->audiencia_beneficios }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    <!-- Gallery Section -->
    @if($landing->images->count() > 1)
        <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="h3 mb-3">Galería</h2>
                    <p class="text-muted">Conoce más sobre nosotros</p>
                </div>
                
                <div class="row g-4">
                    @foreach($landing->images->skip(1) as $image)
                        <div class="col-md-6 col-lg-4">
                            <div class="media-gallery">
                                <img src="{{ asset('storage/' . $image->url) }}" 
                                     alt="{{ $image->descripcion ?: 'Imagen de galería' }}" 
                                     class="img-fluid w-100"
                                     style="height: 250px; object-fit: cover;">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Contact Section -->
    <section class="py-5" style="background-color: var(--color-primary);" id="contacto">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <div class="text-white">
                        <h2 class="h3 mb-3">¿Listo para Comenzar?</h2>
                        @if($landing->descripcion_objetivo)
                            <p class="mb-4 opacity-90">{{ $landing->descripcion_objetivo }}</p>
                        @endif
                        
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                @if($empresa->email)
                                    <div class="mb-3">
                                        <i class="bi bi-envelope me-2"></i>
                                        <a href="mailto:{{ $empresa->email }}" class="text-white text-decoration-none">
                                            {{ $empresa->email }}
                                        </a>
                                    </div>
                                @endif
                                
                                @if($empresa->movil)
                                    <div class="mb-3">
                                        <i class="bi bi-telephone me-2"></i>
                                        <a href="tel:{{ $empresa->movil }}" class="text-white text-decoration-none">
                                            {{ $empresa->movil }}
                                        </a>
                                    </div>
                                @endif
                                
                                @if($empresa->direccion)
                                    <div class="mb-3">
                                        <i class="bi bi-geo-alt me-2"></i>
                                        <span>{{ $empresa->direccion }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Social Media Links -->
                        @if($empresa->hasSocialMedia())
                            <div class="mt-4">
                                <h4 class="h6 mb-3">Síguenos</h4>
                                <div class="d-flex justify-content-center gap-3">
                                    @if($empresa->facebook)
                                        <a href="{{ $empresa->facebook }}" target="_blank" class="text-white">
                                            <i class="bi bi-facebook fs-4"></i>
                                        </a>
                                    @endif
                                    @if($empresa->instagram)
                                        <a href="{{ $empresa->instagram }}" target="_blank" class="text-white">
                                            <i class="bi bi-instagram fs-4"></i>
                                        </a>
                                    @endif
                                    @if($empresa->linkedin)
                                        <a href="{{ $empresa->linkedin }}" target="_blank" class="text-white">
                                            <i class="bi bi-linkedin fs-4"></i>
                                        </a>
                                    @endif
                                    @if($empresa->twitter)
                                        <a href="{{ $empresa->twitter }}" target="_blank" class="text-white">
                                            <i class="bi bi-twitter fs-4"></i>
                                        </a>
                                    @endif
                                    @if($empresa->tiktok)
                                        <a href="{{ $empresa->tiktok }}" target="_blank" class="text-white">
                                            <i class="bi bi-tiktok fs-4"></i>
                                        </a>
                                    @endif
                                    @if($empresa->youtube)
                                        <a href="{{ $empresa->youtube }}" target="_blank" class="text-white">
                                            <i class="bi bi-youtube fs-4"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    @if($landing->logo_url)
                        <img src="{{ asset('storage/' . $landing->logo_url) }}" alt="Logo" style="max-height: 40px;" class="mb-2">
                    @endif
                    <p class="mb-0 text-muted">
                        © {{ date('Y') }} {{ $empresa->nombre }}. Todos los derechos reservados.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    @if($empresa->website)
                        <a href="{{ $empresa->website }}" target="_blank" class="text-muted text-decoration-none">
                            {{ $empresa->website }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Simple animations on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.feature-card, .media-gallery img').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'all 0.6s ease';
            observer.observe(el);
        });
    </script>
</body>
</html>
BLADE;
    }
}