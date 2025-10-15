<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BbbEmpresa extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bbbempresa';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idEmpresa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'email',
        'movil',
        'direccion',
        'slug',
        'estado',
        'facebook',
        'instagram',
        'tiktok',
        'linkedin',
        'youtube',
        'twitter',
        'whatsapp',
        'website',
        'terminos_condiciones',
        'terms_conditions_en',
        'politica_privacidad',
        'privacy_policy_en',
        'politica_cookies',
        'cookies_policy_en',
        'flete',
    ];

    /**
     * Get the plans for the empresa.
     */
    public function planes()
    {
        return $this->hasMany(BbbPlan::class, 'idEmpresa', 'idEmpresa');
    }

    /**
     * Get the carritos for the empresa.
     */
    public function carritos()
    {
        return $this->hasMany(BbbCarrito::class, 'idEmpresa', 'idEmpresa');
    }

    /**
     * Get the users for the empresa.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'idEmpresa', 'idEmpresa');
    }

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Verificar si tiene redes sociales configuradas
     */
    public function hasSocialMedia()
    {
        return !empty($this->facebook) || 
               !empty($this->instagram) || 
               !empty($this->linkedin) || 
               !empty($this->twitter) || 
               !empty($this->tiktok) || 
               !empty($this->youtube);
    }

    /**
     * Obtener todas las redes sociales como array
     */
    public function getSocialMediaArray()
    {
        return array_filter([
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'linkedin' => $this->linkedin,
            'twitter' => $this->twitter,
            'tiktok' => $this->tiktok,
            'youtube' => $this->youtube,
        ]);
    }

    /**
     * Verificar si tiene información de contacto completa
     */
    public function hasCompleteContact()
    {
        return !empty($this->nombre) && 
               !empty($this->email) && 
               (!empty($this->movil) || !empty($this->whatsapp));
    }

    /**
     * Limpiar y formatear URLs de redes sociales
     */
    public function setFacebookAttribute($value)
    {
        $this->attributes['facebook'] = $this->formatSocialUrl($value, 'facebook.com');
    }

    public function setInstagramAttribute($value)
    {
        $this->attributes['instagram'] = $this->formatSocialUrl($value, 'instagram.com');
    }

    public function setLinkedinAttribute($value)
    {
        $this->attributes['linkedin'] = $this->formatSocialUrl($value, 'linkedin.com');
    }

    public function setTwitterAttribute($value)
    {
        $this->attributes['twitter'] = $this->formatSocialUrl($value, 'twitter.com');
    }

    public function setTiktokAttribute($value)
    {
        $this->attributes['tiktok'] = $this->formatSocialUrl($value, 'tiktok.com');
    }

    public function setYoutubeAttribute($value)
    {
        $this->attributes['youtube'] = $this->formatSocialUrl($value, 'youtube.com');
    }

    /**
     * Formatear URL de redes sociales
     */
    private function formatSocialUrl($value, $domain)
    {
        if (empty($value)) {
            return null;
        }

        // Si ya es una URL completa y válida, devolverla
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        // Si no comienza con http, agregar https
        if (!str_starts_with($value, 'http')) {
            // Si contiene el dominio, agregar solo https
            if (str_contains($value, $domain)) {
                return 'https://' . ltrim($value, '/');
            } else {
                // Si no contiene el dominio, agregarlo
                return 'https://' . $domain . '/' . ltrim($value, '/');
            }
        }

        return $value;
    }

    /**
     * Get the landing page for the empresa.
     */
    public function landing()
    {
        return $this->hasOne(BbbLanding::class, 'idEmpresa', 'idEmpresa');
    }

    /**
     * Get all landing pages for the empresa (si hubiera múltiples en el futuro).
     */
    public function landings()
    {
        return $this->hasMany(BbbLanding::class, 'idEmpresa', 'idEmpresa');
    }

    /**
     * Generate a unique slug from the company name.
     */
    public function generateSlug()
    {
        $baseSlug = $this->createSlugFromName($this->nombre);
        $slug = $baseSlug;
        $counter = 1;

        // Ensure uniqueness
        while (self::where('slug', $slug)->where('idEmpresa', '!=', $this->idEmpresa)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Create a slug from a name string.
     */
    private function createSlugFromName($name)
    {
        // Convert to lowercase
        $slug = mb_strtolower($name, 'UTF-8');
        
        // Replace special characters and accents
        $slug = $this->replaceAccents($slug);
        
        // Replace spaces and special characters with hyphens
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        
        // Remove leading/trailing hyphens and multiple consecutive hyphens
        $slug = trim(preg_replace('/-+/', '-', $slug), '-');
        
        return $slug;
    }

    /**
     * Replace accented characters with their ASCII equivalents.
     */
    private function replaceAccents($string)
    {
        $accents = [
            'á' => 'a', 'à' => 'a', 'ä' => 'a', 'â' => 'a', 'ā' => 'a', 'ã' => 'a',
            'é' => 'e', 'è' => 'e', 'ë' => 'e', 'ê' => 'e', 'ē' => 'e',
            'í' => 'i', 'ì' => 'i', 'ï' => 'i', 'î' => 'i', 'ī' => 'i',
            'ó' => 'o', 'ò' => 'o', 'ö' => 'o', 'ô' => 'o', 'ō' => 'o', 'õ' => 'o',
            'ú' => 'u', 'ù' => 'u', 'ü' => 'u', 'û' => 'u', 'ū' => 'u',
            'ñ' => 'n', 'ç' => 'c',
            'Á' => 'a', 'À' => 'a', 'Ä' => 'a', 'Â' => 'a', 'Ā' => 'a', 'Ã' => 'a',
            'É' => 'e', 'È' => 'e', 'Ë' => 'e', 'Ê' => 'e', 'Ē' => 'e',
            'Í' => 'i', 'Ì' => 'i', 'Ï' => 'i', 'Î' => 'i', 'Ī' => 'i',
            'Ó' => 'o', 'Ò' => 'o', 'Ö' => 'o', 'Ô' => 'o', 'Ō' => 'o', 'Õ' => 'o',
            'Ú' => 'u', 'Ù' => 'u', 'Ü' => 'u', 'Û' => 'u', 'Ū' => 'u',
            'Ñ' => 'n', 'Ç' => 'c'
        ];

        return strtr($string, $accents);
    }

    /**
     * Update or generate slug if needed.
     */
    public function updateSlug()
    {
        if (empty($this->slug) || $this->isDirty('nombre')) {
            $this->slug = $this->generateSlug();
        }
    }

    /**
     * Get the route key for the model (use slug instead of id).
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the landing views directory path.
     */
    public function getLandingViewsPath()
    {
        return resource_path('views/landings/' . $this->slug);
    }

    /**
     * Get the landing storage path.
     */
    public function getLandingStoragePath()
    {
        return 'landing/' . $this->slug;
    }

    /**
     * Check if landing views directory exists.
     */
    public function hasLandingViews()
    {
        return is_dir($this->getLandingViewsPath());
    }

    /**
     * Create landing views directory if it doesn't exist.
     */
    public function createLandingViews()
    {
        $viewsPath = $this->getLandingViewsPath();
        
        if (!is_dir($viewsPath)) {
            mkdir($viewsPath, 0755, true);
        }

        return $viewsPath;
    }

    /**
     * Estados posibles para las landing pages.
     */
    public static function getLandingEstados()
    {
        return [
            'borrador' => 'Borrador',
            'en_construccion' => 'En Construcción',
            'publicada' => 'Publicada',
            'vencida' => 'Vencida',
        ];
    }

    /**
     * Get the public landing URL.
     */
    public function getLandingUrl()
    {
        return route('public.landing', ['slug' => $this->slug]);
    }

    /**
     * Check if landing is published.
     */
    public function isLandingPublished()
    {
        return $this->estado === 'publicada';
    }

    /**
     * Check if landing is under construction.
     */
    public function isLandingUnderConstruction()
    {
        return $this->estado === 'en_construccion';
    }

    /**
     * Check if landing is expired.
     */
    public function isLandingExpired()
    {
        return $this->estado === 'vencida';
    }

    /**
     * Set landing status to under construction.
     */
    public function setLandingUnderConstruction()
    {
        $this->estado = 'en_construccion';
        $this->save();
    }

    /**
     * Set landing status to published.
     */
    public function publishLanding()
    {
        $this->estado = 'publicada';
        $this->save();
    }

    /**
     * Get the productos for the empresa.
     */
    public function productos()
    {
        return $this->hasMany(BbbProducto::class, 'idEmpresa', 'idEmpresa');
    }

    /**
     * Get active productos for the empresa.
     */
    public function productosActivos()
    {
        return $this->hasMany(BbbProducto::class, 'idEmpresa', 'idEmpresa')
                    ->where('estado', 'activo');
    }

    /**
     * Scope: solo empresas con landing publicada.
     */
    public function scopePublicadas($query)
    {
        return $query->where('estado', 'publicada');
    }

    /**
     * Scope: empresas cuya licencia está vigente (usuario con suscripción activa o trial vigente).
     */
    public function scopeConLicenciaVigente($query)
    {
        return $query->whereExists(function ($sub) {
            $sub->select(DB::raw(1))
                ->from('users')
                ->whereColumn('users.idEmpresa', 'bbbempresa.idEmpresa')
                ->where(function ($q) {
                    $now = now();
                    $q->where('users.subscription_ends_at', '>', $now)
                      ->orWhere('users.trial_ends_at', '>', $now);
                });
        });
    }

    /**
     * Get the clientes for the empresa.
     */
    public function clientes()
    {
        return $this->hasMany(BbbCliente::class, 'idEmpresa', 'idEmpresa');
    }

    /**
     * Get the ventas for the empresa.
     */
    public function ventas()
    {
        return $this->hasMany(BbbVentaOnline::class, 'idEmpresa', 'idEmpresa');
    }

    /**
     * Get the configuracion de pagos for the empresa.
     */
    public function configuracionPagos()
    {
        return $this->hasOne(BbbEmpresaPagos::class, 'idEmpresa', 'idEmpresa');
    }
}
