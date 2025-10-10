<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BbbProductoImagen extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bbbproductoimagenes';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idImagen';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idProducto',
        'url_imagen',
        'es_principal',
        'orden'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'es_principal' => 'boolean',
        'orden' => 'integer',
        'created_at' => 'datetime',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Get the producto that owns the imagen.
     */
    public function producto()
    {
        return $this->belongsTo(BbbProducto::class, 'idProducto', 'idProducto');
    }

    /**
     * Scope a query to only include principal images.
     */
    public function scopePrincipal($query)
    {
        return $query->where('es_principal', true);
    }

    /**
     * Scope a query to order by orden.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('orden', 'asc');
    }

    /**
     * Get the full URL for the image.
     */
    public function getUrlCompleteAttribute()
    {
        return asset('storage/' . $this->url_imagen);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
        
        // Cuando se marca una imagen como principal, desmarcar las otras
        static::saving(function ($imagen) {
            if ($imagen->es_principal) {
                static::where('idProducto', $imagen->idProducto)
                      ->where('idImagen', '!=', $imagen->idImagen)
                      ->update(['es_principal' => false]);
            }
        });
    }
}