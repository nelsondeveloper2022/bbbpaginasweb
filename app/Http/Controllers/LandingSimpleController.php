<?php

namespace App\Http\Controllers;

use App\Models\BbbLanding;
use App\Models\BbbLandingMedia;
use App\Models\BbbEmpresa;
use App\Mail\LandingPublishedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class LandingSimpleController extends Controller
{
    /**
     * Display the simple landing configuration form.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Verificar si el usuario tiene empresa asignada
        $empresa = null;
        if ($user->idEmpresa) {
            $empresa = BbbEmpresa::find($user->idEmpresa);
        }
        
        // Si no hay empresa, crear una nueva instancia para evitar errores
        if (!$empresa) {
            $empresa = new BbbEmpresa();
            $empresa->estado = 'nuevo'; // Estado por defecto para usuarios nuevos
        }
        
        $landing = null;
        if ($user->idEmpresa) {
            $landing = BbbLanding::where('idEmpresa', $user->idEmpresa)->first();
        }
        
        // Si no existe una landing, crear una nueva instancia vacía
        if (!$landing) {
            $landing = new BbbLanding();
            if ($user->idEmpresa) {
                $landing->idEmpresa = $user->idEmpresa;
            }
        }

        // Verificar si el perfil está completo
        $profileComplete = $user->hasCompleteProfile() && $user->isEmailVerified();
        $profileCompletion = $user->getProfileCompletion();
        $profileDetails = $user->getProfileCompletionDetails();

        // Determinar el estado de la landing para el sistema de bloqueo
        $estadoLanding = $empresa->estado ?? 'nuevo';
        $isReadOnly = ($estadoLanding === 'en_construccion');
        $isPublished = ($estadoLanding === 'publicada');
        
        // Definir campos editables cuando está publicada
        $editableFieldsWhenPublished = [
            'logo', 'media', 'color_principal', 'color_secundario', 
            'whatsapp', 'facebook', 'instagram', 'twitter'
        ];

        // Cargar imágenes adicionales existentes
        $existingMedia = [];
        if ($landing->exists) {
            $existingMedia = BbbLandingMedia::where('idLanding', $landing->idLanding)
                ->where('tipo', 'imagen')
                ->get();
        }

        return view('landing.configurar_simple', compact(
            'empresa', 
            'landing', 
            'profileComplete',
            'profileCompletion',
            'profileDetails',
            'estadoLanding',
            'isReadOnly',
            'isPublished',
            'editableFieldsWhenPublished',
            'existingMedia'
        ));
    }

    /**
     * Store or update landing page (simplified version).
     */
    public function store(Request $request)
    {
        Log::info('=== USANDO LANDING SIMPLE CONTROLLER ===');
        
        $user = Auth::user();
        
        // Verificar si el perfil está completo
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
        
        $estadoLanding = $empresa->estado ?? 'nuevo';
        $isPublished = ($estadoLanding === 'publicada');
        $isInConstruction = ($estadoLanding === 'en_construccion');
        
        // SISTEMA DE BLOQUEO: No permitir edición si está en construcción
        if ($isInConstruction) {
            return redirect()->back()
                ->with('warning', 'No puedes editar la landing page mientras está en construcción. Debes publicarla primero.')
                ->withInput();
        }
        
        // Verificar si ya existe una landing
        $landing = BbbLanding::where('idEmpresa', $user->idEmpresa)->first();
        
        // VALIDACIÓN CONDICIONAL SEGÚN ESTADO
        if ($isPublished) {
            // Si está publicada, solo validar campos editables
            $validationRules = [
                'whatsapp' => 'required|string|max:20',
                'color_principal' => 'nullable|string|max:7',
                'color_secundario' => 'nullable|string|max:7',
                'facebook' => 'nullable|url|max:255',
                'instagram' => 'nullable|url|max:255',
                'twitter' => 'nullable|url|max:255',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'media.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ];
        } else {
            // Si es nueva o no publicada, validar todos los campos
            $validationRules = [
                'empresa_nombre' => 'required|string|max:255',
                'whatsapp' => 'required|string|max:20',
                'titulo_principal' => 'required|string|max:255',
                'descripcion' => 'required|string|max:1000',
                'color_principal' => 'nullable|string|max:7',
                'color_secundario' => 'nullable|string|max:7',
                'facebook' => 'nullable|url|max:255',
                'instagram' => 'nullable|url|max:255',
                'twitter' => 'nullable|url|max:255',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'media.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ];
        }
        
        $request->validate($validationRules, [
            'empresa_nombre.required' => 'El nombre de la empresa es obligatorio.',
            'whatsapp.required' => 'El número de WhatsApp es obligatorio.',
            'titulo_principal.required' => 'El título principal es obligatorio.',
            'descripcion.required' => 'La descripción del negocio es obligatoria.',
            'descripcion.max' => 'La descripción no puede tener más de 1000 caracteres.',
            'logo.image' => 'El logo debe ser una imagen válida.',
            'logo.mimes' => 'El logo debe ser JPG, PNG, GIF, SVG o WEBP.',
            'logo.max' => 'El logo no puede ser mayor a 2MB.',
            'facebook.url' => 'La URL de Facebook debe ser válida.',
            'instagram.url' => 'La URL de Instagram debe ser válida.',
            'twitter.url' => 'La URL de Twitter debe ser válida.',
            'media.*.image' => 'Todos los archivos deben ser imágenes válidas.',
            'media.*.mimes' => 'Las imágenes deben ser JPG, PNG, GIF, SVG o WEBP.',
            'media.*.max' => 'Las imágenes no pueden ser mayores a 2MB.',
        ]);

        try {
            Log::info('Iniciando guardado de landing', [
                'user_id' => $user->id,
                'empresa_id' => $user->idEmpresa,
                'estado_actual' => $estadoLanding,
                'request_data' => $request->except(['logo', 'media'])
            ]);
            
            // ACTUALIZACIÓN CONDICIONAL SEGÚN ESTADO
            if ($isPublished) {
                // Si está publicada, solo actualizar campos permitidos
                $empresa->whatsapp = $request->whatsapp;
                $empresa->facebook = $request->facebook;
                $empresa->instagram = $request->instagram;
                $empresa->twitter = $request->twitter;
                
                if ($landing) {
                    $landing->color_principal = $request->color_principal ?? $landing->color_principal;
                    $landing->color_secundario = $request->color_secundario ?? $landing->color_secundario;
                }
            } else {
                // Si no está publicada, actualizar todos los campos
                $empresa->nombre = $request->empresa_nombre;
                $empresa->whatsapp = $request->whatsapp;
                $empresa->facebook = $request->facebook;
                $empresa->instagram = $request->instagram;
                $empresa->twitter = $request->twitter;
                
                // Crear o actualizar landing
                if (!$landing) {
                    $landing = new BbbLanding();
                    $landing->idEmpresa = $user->idEmpresa;
                }
                
                $landing->titulo_principal = $request->titulo_principal;
                $landing->descripcion = $request->descripcion;
                $landing->color_principal = $request->color_principal ?? '#007bff';
                $landing->color_secundario = $request->color_secundario ?? '#6c757d';
                $landing->objetivo = 'generar_contactos'; // Valor fijo para formulario básico
                $landing->subtitulo = $request->titulo_principal . ' - Contáctanos';
                $landing->estilo = 'moderno';
                $landing->tipografia = 'inter';
            }
            
            $empresa->save();
            
            // Manejar logo si se subió uno nuevo (siempre permitido)
            if ($request->hasFile('logo') && $landing) {
                // Eliminar logo anterior si existe
                if ($landing->logo_url && Storage::exists($landing->logo_url)) {
                    Storage::delete($landing->logo_url);
                }
                
                $logoPath = $request->file('logo')->store('logos', 'public');
                $landing->logo_url = $logoPath;
            }
            
            if ($landing) {
                $landing->save();
            }
            
            // Manejar imágenes adicionales si se subieron (siempre permitido)
            if ($request->hasFile('media') && $landing) {
                foreach ($request->file('media') as $mediaFile) {
                    $mediaPath = $mediaFile->store('landing-media', 'public');
                    
                    BbbLandingMedia::create([
                        'idLanding' => $landing->idLanding,
                        'tipo' => 'imagen',
                        'url' => $mediaPath,
                        'descripcion' => $mediaFile->getClientOriginalName(),
                    ]);
                }
            }
            
            // Lógica de guardado según estado
            if ($isPublished) {
                return redirect()->route('admin.landing.configurar')
                    ->with('success', 'Cambios guardados exitosamente en tu landing page publicada.');
            } else {
                // Auto-guardar como "en_construccion" (no publicada automáticamente)
                $empresa->estado = 'en_construccion';
                $empresa->save();
                
                return redirect()->route('admin.landing.configurar')
                    ->with('success', 'Landing page guardada como borrador. Podrás publicarla cuando esté lista.');
            }
            
        } catch (\Exception $e) {
            Log::error('Error guardando landing: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Hubo un error al guardar la configuración. Por favor intenta nuevamente.')
                ->withInput();
        }
    }

    /**
     * Publish the landing page from construction to published state.
     */
    public function publish()
    {
        $user = Auth::user();
        $empresa = BbbEmpresa::find($user->idEmpresa);
        $landing = BbbLanding::where('idEmpresa', $user->idEmpresa)->first();
        
        if (!$empresa) {
            return redirect()->back()
                ->with('error', 'No se pudo encontrar la información de tu empresa.');
        }
        
        if (!$landing) {
            return redirect()->back()
                ->with('error', 'No se encontró la configuración de la landing page.');
        }
        
        if ($empresa->estado !== 'en_construccion') {
            return redirect()->back()
                ->with('warning', 'La landing page ya está publicada o no está en construcción.');
        }
        
        try {
            // Cambiar estado a publicada
            $empresa->estado = 'publicada';
            $empresa->save();
            
            // Enviar notificación de publicación
            if ($empresa->email) {
                Mail::to($empresa->email)->send(new LandingPublishedNotification($empresa, $landing));
            }
            
            Log::info('Landing page publicada', [
                'empresa_id' => $empresa->idEmpresa,
                'landing_id' => $landing->idLanding,
                'user_id' => $user->id
            ]);
            
            return redirect()->route('admin.landing.configurar')
                ->with('success', '¡Landing page publicada exitosamente! Ya está disponible para tus clientes.');
                
        } catch (\Exception $e) {
            Log::error('Error publicando landing: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Hubo un error al publicar la landing page. Por favor intenta nuevamente.');
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

        // Para estado en construcción, mostrar vista previa simple
        if ($empresa->estado === 'en_construccion') {
            return view('landing.preview', compact('empresa', 'landing'));
        }

        // Verificar que existe el slug de la empresa para landing publicada
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

        // Redirigir a la landing pública si está publicada
        return redirect()->to(url($empresa->slug));
    }

    /**
     * Delete a media file from landing page.
     */
    public function deleteMedia($mediaId)
    {
        try {
            $user = Auth::user();
            
            // Buscar el archivo de media
            $media = BbbLandingMedia::find($mediaId);
            
            if (!$media) {
                return response()->json([
                    'success' => false,
                    'message' => 'Archivo no encontrado'
                ], 404);
            }

            // Verificar que el usuario sea el propietario
            $landing = BbbLanding::find($media->idLanding);
            if (!$landing || $landing->idEmpresa != $user->idEmpresa) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tiene permisos para eliminar este archivo'
                ], 403);
            }

            // Eliminar el archivo físico del storage
            if (Storage::exists($media->url)) {
                Storage::delete($media->url);
            }

            // Eliminar el registro de la base de datos
            $media->delete();

            return response()->json([
                'success' => true,
                'message' => 'Imagen eliminada correctamente'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al eliminar media: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor'
            ], 500);
        }
    }
}