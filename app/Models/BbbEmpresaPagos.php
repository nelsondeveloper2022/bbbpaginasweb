<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BbbEmpresaPagos extends Model
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
        'moneda'
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
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the empresa that owns the configuracion de pagos.
     */
    public function empresa()
    {
        return $this->belongsTo(BbbEmpresa::class, 'idEmpresa', 'idEmpresa');
    }

    /**
     * Get the pasarelas for the configuracion de pagos.
     */
    public function pasarelas()
    {
        return $this->hasMany(BbbEmpresaPasarela::class, 'idPagoConfig', 'idPagoConfig');
    }

    /**
     * Get active pasarelas.
     */
    public function pasarelasActivas()
    {
        return $this->hasMany(BbbEmpresaPasarela::class, 'idPagoConfig', 'idPagoConfig')
                    ->where('activo', true);
    }

    /**
     * Scope a query to filter by empresa.
     */
    public function scopeForEmpresa($query, $idEmpresa)
    {
        return $query->where('idEmpresa', $idEmpresa);
    }

    /**
     * Get default currency symbol.
     */
    public function getMonedaSymbolAttribute()
    {
        return match($this->moneda) {
            'COP' => '$',
            'USD' => 'US$',
            'EUR' => '€',
            default => '$'
        };
    }

    /**
     * Check if payments are enabled.
     */
    public function isPagosEnabled()
    {
        return $this->pago_online && $this->pasarelasActivas()->exists();
    }
}