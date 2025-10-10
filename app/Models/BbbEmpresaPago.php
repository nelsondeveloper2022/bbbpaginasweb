<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BbbEmpresaPago extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bbbempresapagos';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idPagoConfig';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idEmpresa',
        'pago_online',
        'moneda',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'pago_online' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the empresa that owns the payment configuration.
     */
    public function empresa()
    {
        return $this->belongsTo(BbbEmpresa::class, 'idEmpresa', 'idEmpresa');
    }

    /**
     * Get the payment gateways for this configuration.
     */
    public function pasarelas()
    {
        return $this->hasMany(BbbEmpresaPasarela::class, 'idPagoConfig', 'idPagoConfig');
    }

    /**
     * Get the active Wompi gateway.
     */
    public function wompiPasarela()
    {
        return $this->hasOne(BbbEmpresaPasarela::class, 'idPagoConfig', 'idPagoConfig')
            ->where('nombre_pasarela', 'Wompi')
            ->where('activo', true);
    }

    /**
     * Check if online payments are enabled.
     */
    public function isPagoOnlineEnabled(): bool
    {
        return (bool) $this->pago_online;
    }

    /**
     * Enable online payments.
     */
    public function enablePagoOnline(): void
    {
        $this->update(['pago_online' => true]);
    }

    /**
     * Disable online payments.
     */
    public function disablePagoOnline(): void
    {
        $this->update(['pago_online' => false]);
    }
}
