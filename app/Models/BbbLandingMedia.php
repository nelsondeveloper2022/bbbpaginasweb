<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BbbLandingMedia extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bbb_landing_media';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idMedia';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idLanding',
        'tipo',
        'url',
        'descripcion',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tipo' => 'string',
    ];

    /**
     * Get the landing that owns the media.
     */
    public function landing()
    {
        return $this->belongsTo(BbbLanding::class, 'idLanding', 'idLanding');
    }

    /**
     * Get the media URL with full path.
     */
    public function getFullUrlAttribute()
    {
        if ($this->url) {
            return asset('storage/' . $this->url);
        }
        return null;
    }

    /**
     * Scope a query to only include images.
     */
    public function scopeImages($query)
    {
        return $query->where('tipo', 'imagen');
    }

    /**
     * Scope a query to only include icons.
     */
    public function scopeIcons($query)
    {
        return $query->where('tipo', 'icono');
    }

    /**
     * Get media types available.
     */
    public static function getTipoOptions()
    {
        return [
            'imagen' => 'Imagen',
            'icono' => 'Icono',
        ];
    }
}