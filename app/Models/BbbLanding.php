<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BbbLanding extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bbb_landing';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idLanding';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idEmpresa',
        'objetivo',
        'descripcion_objetivo',
        'audiencia_descripcion',
        'audiencia_problemas',
        'audiencia_beneficios',
        'color_principal',
        'color_secundario',
        'estilo',
        'tipografia',
        'logo_url',
        'titulo_principal',
        'subtitulo',
        'descripcion',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the empresa that owns the landing.
     */
    public function empresa()
    {
        return $this->belongsTo(BbbEmpresa::class, 'idEmpresa', 'idEmpresa');
    }

    /**
     * Get the media for the landing page.
     */
    public function media()
    {
        return $this->hasMany(BbbLandingMedia::class, 'idLanding', 'idLanding');
    }

    /**
     * Get only images from media.
     */
    public function images()
    {
        return $this->hasMany(BbbLandingMedia::class, 'idLanding', 'idLanding')
                    ->where('tipo', 'imagen');
    }

    /**
     * Get only icons from media.
     */
    public function icons()
    {
        return $this->hasMany(BbbLandingMedia::class, 'idLanding', 'idLanding')
                    ->where('tipo', 'icono');
    }

    /**
     * Get the logo URL with full path.
     */
    public function getLogoFullUrlAttribute()
    {
        if ($this->logo_url) {
            return asset('storage/' . $this->logo_url);
        }
        return null;
    }

    /**
     * Objetivos predefinidos para el select.
     */
    public static function getObjetivoOptions()
    {
        return [
            'vender_producto' => 'Vender producto',
            'captar_leads' => 'Captar leads',
            'reservas' => 'Reservas',
            'descargas' => 'Descargas',
            'promocionar_servicio' => 'Promocionar servicio',
            'construir_comunidad' => 'Construir comunidad',
            'generar_suscripciones' => 'Generar suscripciones',
            'otro' => 'Otro',
        ];
    }

    /**
     * Estilos predefinidos para el select.
     */
    public static function getEstiloOptions()
    {
        return [
            'minimalista' => 'Minimalista',
            'moderno' => 'Moderno',
            'elegante' => 'Elegante',
            'juvenil' => 'Juvenil',
            'corporativo' => 'Corporativo',
            'creativo' => 'Creativo',
            'clasico' => 'Clásico',
        ];
    }

    /**
     * Tipografías predefinidas para el select.
     */
    public static function getTipografiaOptions()
    {
        return [
            'Inter' => 'Inter',
            'Roboto' => 'Roboto',
            'Open Sans' => 'Open Sans',
            'Montserrat' => 'Montserrat',
            'Poppins' => 'Poppins',
            'Lato' => 'Lato',
            'Source Sans Pro' => 'Source Sans Pro',
            'Nunito' => 'Nunito',
            'Arial' => 'Arial',
            'Helvetica' => 'Helvetica',
        ];
    }
}