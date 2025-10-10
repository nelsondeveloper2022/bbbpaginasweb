<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BbbVentaOnline extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bbbventaonline';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idVenta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idEmpresa',
        'idCliente',
        'fecha',
        'total',
        'totalEnvio',
        'estado',
        'metodo_pago',
        'observaciones'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha' => 'datetime',
        'total' => 'decimal:2',
        'totalEnvio' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the empresa that owns the venta.
     */
    public function empresa()
    {
        return $this->belongsTo(BbbEmpresa::class, 'idEmpresa', 'idEmpresa');
    }

    /**
     * Get the cliente that owns the venta.
     */
    public function cliente()
    {
        return $this->belongsTo(BbbCliente::class, 'idCliente', 'idCliente');
    }

    /**
     * Get the detalles for the venta.
     */
    public function detalles()
    {
        return $this->hasMany(BbbVentaOnlineDetalle::class, 'idVenta', 'idVenta');
    }

    /**
     * Get the payment confirmations for the venta.
     */
    public function confirmacionesPago()
    {
        return $this->hasMany(BbbVentaPagoConfirmacion::class, 'idVenta', 'idVenta');
    }

    /**
     * Get the latest payment confirmation.
     */
    public function ultimaConfirmacionPago()
    {
        return $this->hasOne(BbbVentaPagoConfirmacion::class, 'idVenta', 'idVenta')
            ->latestOfMany('fecha_confirmacion');
    }

    /**
     * Scope a query to filter by empresa.
     */
    public function scopeForEmpresa($query, $idEmpresa)
    {
        return $query->where('idEmpresa', $idEmpresa);
    }

    /**
     * Scope a query to filter by estado.
     */
    public function scopeByEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeDateRange($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha', [$fechaInicio, $fechaFin]);
    }

    /**
     * Get formatted total.
     */
    public function getTotalFormateadoAttribute()
    {
        return number_format($this->total, 0, ',', '.');
    }

    /**
     * Get status badge class.
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->estado) {
            'pendiente' => 'badge bg-warning',
            'completada' => 'badge bg-success',
            'cancelada' => 'badge bg-danger',
            'procesando' => 'badge bg-info',
            default => 'badge bg-secondary'
        };
    }

    /**
     * Get status display name.
     */
    public function getStatusDisplayAttribute()
    {
        return match($this->estado) {
            'pendiente' => 'Pendiente',
            'completada' => 'Completada',
            'cancelada' => 'Cancelada',
            'procesando' => 'Procesando',
            default => ucfirst($this->estado)
        };
    }

    /**
     * Calculate total from detalles.
     */
    public function calculateTotal()
    {
        return $this->detalles()->sum('subtotal');
    }

    /**
     * Get items count.
     */
    public function getTotalItemsAttribute()
    {
        return $this->detalles()->sum('cantidad');
    }
}