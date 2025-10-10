<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BbbVentaPagoConfirmacion extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bbbventapagoconfirmacion';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idPagoConfirmacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idVenta',
        'idEmpresa',
        'referencia',
        'transaccion_id',
        'monto',
        'moneda',
        'estado',
        'respuesta_completa',
        'fecha_confirmacion',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'monto' => 'decimal:2',
        'respuesta_completa' => 'array',
        'fecha_confirmacion' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the venta that owns the payment confirmation.
     */
    public function venta()
    {
        return $this->belongsTo(BbbVentaOnline::class, 'idVenta', 'idVenta');
    }

    /**
     * Get the empresa that owns the payment confirmation.
     */
    public function empresa()
    {
        return $this->belongsTo(BbbEmpresa::class, 'idEmpresa', 'idEmpresa');
    }

    /**
     * Check if payment is approved.
     */
    public function isApproved(): bool
    {
        return $this->estado === 'APPROVED';
    }

    /**
     * Check if payment is pending.
     */
    public function isPending(): bool
    {
        return $this->estado === 'PENDING';
    }

    /**
     * Check if payment is declined.
     */
    public function isDeclined(): bool
    {
        return $this->estado === 'DECLINED';
    }

    /**
     * Check if payment is voided.
     */
    public function isVoided(): bool
    {
        return $this->estado === 'VOIDED';
    }

    /**
     * Check if payment is error.
     */
    public function isError(): bool
    {
        return $this->estado === 'ERROR';
    }

    /**
     * Get status badge color for UI.
     */
    public function getStatusBadgeColor(): string
    {
        return match($this->estado) {
            'APPROVED' => 'success',
            'PENDING' => 'warning',
            'DECLINED' => 'danger',
            'VOIDED' => 'secondary',
            'ERROR' => 'danger',
            default => 'secondary',
        };
    }

    /**
     * Get status text in Spanish.
     */
    public function getStatusText(): string
    {
        return match($this->estado) {
            'APPROVED' => 'Aprobado',
            'PENDING' => 'Pendiente',
            'DECLINED' => 'Rechazado',
            'VOIDED' => 'Anulado',
            'ERROR' => 'Error',
            default => 'Desconocido',
        };
    }

    /**
     * Get formatted amount with currency.
     */
    public function getFormattedAmount(): string
    {
        $symbol = $this->moneda === 'COP' ? '$' : $this->moneda . ' ';
        return $symbol . number_format($this->monto, 2, ',', '.');
    }

    /**
     * Scope to filter by status.
     */
    public function scopeByStatus($query, string $status)
    {
        return $query->where('estado', $status);
    }

    /**
     * Scope to filter approved payments.
     */
    public function scopeApproved($query)
    {
        return $query->where('estado', 'APPROVED');
    }

    /**
     * Scope to filter pending payments.
     */
    public function scopePending($query)
    {
        return $query->where('estado', 'PENDING');
    }

    /**
     * Scope to filter by empresa.
     */
    public function scopeByEmpresa($query, int $idEmpresa)
    {
        return $query->where('idEmpresa', $idEmpresa);
    }
}
