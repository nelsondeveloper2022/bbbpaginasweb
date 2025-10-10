<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BbbProducto extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bbbproductos';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idProducto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idEmpresa',
        'nombre',
        'referencia',
        'slug',
        'descripcion',
        'precio',
        'costo',
        'stock',
        'imagen',
        'estado'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'precio' => 'integer',
        'costo' => 'integer',
        'stock' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($producto) {
            if (empty($producto->slug)) {
                $producto->slug = Str::slug($producto->nombre);
            }
        });

        static::updating(function ($producto) {
            if ($producto->isDirty('nombre') && empty($producto->slug)) {
                $producto->slug = Str::slug($producto->nombre);
            }
        });
    }

    /**
     * Get the empresa that owns the producto.
     */
    public function empresa()
    {
        return $this->belongsTo(BbbEmpresa::class, 'idEmpresa', 'idEmpresa');
    }

    /**
     * Get the imagenes for the producto.
     */
    public function imagenes()
    {
        return $this->hasMany(BbbProductoImagen::class, 'idProducto', 'idProducto');
    }

    /**
     * Get the imagen principal for the producto.
     */
    public function imagenPrincipal()
    {
        return $this->hasOne(BbbProductoImagen::class, 'idProducto', 'idProducto')
                    ->where('es_principal', 1);
    }

    /**
     * Get the detalles de venta for the producto.
     */
    public function detallesVenta()
    {
        return $this->hasMany(BbbVentaOnlineDetalle::class, 'idProducto', 'idProducto');
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('estado', 'activo');
    }

    /**
     * Scope a query to filter by empresa.
     */
    public function scopeForEmpresa($query, $idEmpresa)
    {
        return $query->where('idEmpresa', $idEmpresa);
    }

    /**
     * Scope a query to search products by multiple fields.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('nombre', 'like', "%{$search}%")
              ->orWhere('descripcion', 'like', "%{$search}%")
              ->orWhere('referencia', 'like', "%{$search}%");
        });
    }

    /**
     * Get the URL for the product image.
     */
    public function getImagenUrlAttribute()
    {
        if ($this->imagen) {
            return asset('storage/' . $this->imagen);
        }
        
        $imagenPrincipal = $this->imagenPrincipal;
        if ($imagenPrincipal) {
            return asset('storage/' . $imagenPrincipal->url_imagen);
        }

        return asset('images/no-image.png');
    }

    /**
     * Get formatted price.
     */
    public function getPrecioFormateadoAttribute()
    {
        return number_format($this->precio, 0, ',', '.');
    }

    /**
     * Get formatted cost.
     */
    public function getCostoFormateadoAttribute()
    {
        return number_format($this->costo, 0, ',', '.');
    }

    /**
     * Get profit margin.
     */
    public function getMargenGananciaAttribute()
    {
        if ($this->costo <= 0) {
            return 0;
        }
        return (($this->precio - $this->costo) / $this->costo) * 100;
    }

    /**
     * Get all images (including main image).
     */
    public function getAllImagesAttribute()
    {
        $images = collect();
        
        // Agregar imagen principal si existe
        if ($this->imagen) {
            $images->push([
                'url' => asset('storage/' . $this->imagen),
                'alt' => $this->nombre . ' - Imagen principal',
                'tipo' => 'principal'
            ]);
        }
        
        // Agregar imágenes de galería
        foreach ($this->imagenes as $imagen) {
            $images->push([
                'url' => asset('storage/' . $imagen->url_imagen),
                'alt' => $this->nombre . ' - Galería',
                'tipo' => 'galeria'
            ]);
        }
        
        return $images;
    }

    /**
     * Get default product icon based on name or category.
     */
    public function getDefaultIconAttribute()
    {
        $nombre = strtolower($this->nombre);
        
        if (str_contains($nombre, 'laptop') || str_contains($nombre, 'computador')) {
            return 'bi-laptop';
        } elseif (str_contains($nombre, 'telefono') || str_contains($nombre, 'celular') || str_contains($nombre, 'movil')) {
            return 'bi-phone';
        } elseif (str_contains($nombre, 'tablet')) {
            return 'bi-tablet';
        } elseif (str_contains($nombre, 'ropa') || str_contains($nombre, 'camisa') || str_contains($nombre, 'pantalon')) {
            return 'bi-bag';
        } elseif (str_contains($nombre, 'libro')) {
            return 'bi-book';
        } elseif (str_contains($nombre, 'zapato') || str_contains($nombre, 'calzado')) {
            return 'bi-bootstrap';
        } else {
            return 'bi-box-seam';
        }
    }

    /**
     * Check if product has stock.
     */
    public function hasStock($cantidad = 1)
    {
        return $this->stock >= $cantidad;
    }
}