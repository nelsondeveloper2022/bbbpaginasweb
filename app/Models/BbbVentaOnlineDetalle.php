<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BbbVentaOnlineDetalle extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bbbventaonlinedetalle';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idDetalle';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idVenta',
        'idProducto',
        'cantidad',
        'precio_unitario',
        'subtotal'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'cantidad' => 'integer',
        'precio_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the venta that owns the detalle.
     */
    public function venta()
    {
        return $this->belongsTo(BbbVentaOnline::class, 'idVenta', 'idVenta');
    }

    /**
     * Get the producto that owns the detalle.
     */
    public function producto()
    {
        return $this->belongsTo(BbbProducto::class, 'idProducto', 'idProducto');
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
        
        // Calcular subtotal automáticamente
        static::saving(function ($detalle) {
            $detalle->subtotal = $detalle->cantidad * $detalle->precio_unitario;
        });
    }

    /**
     * Get formatted subtotal.
     */
    public function getSubtotalFormateadoAttribute()
    {
        return number_format($this->subtotal, 0, ',', '.');
    }

    /**
     * Get formatted precio unitario.
     */
    public function getPrecioUnitarioFormateadoAttribute()
    {
        return number_format($this->precio_unitario, 0, ',', '.');
    }
}