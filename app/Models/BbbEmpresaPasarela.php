<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BbbEmpresaPasarela extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bbbempresapasarelas';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idPasarela';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idPagoConfig',
        'nombre_pasarela',
        'public_key',
        'private_key',
        'extra_config',
        'activo'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'extra_config' => 'array',
        'activo' => 'boolean',
        'created_at' => 'datetime',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'private_key',
    ];

    /**
     * Get the configuracion de pagos that owns the pasarela.
     */
    public function pagoConfig()
    {
        return $this->belongsTo(BbbEmpresaPago::class, 'idPagoConfig', 'idPagoConfig');
    }

    /**
     * Get the empresa through the payment configuration.
     */
    public function empresa()
    {
        return $this->pagoConfig->empresa();
    }

    /**
     * Scope a query to only include active pasarelas.
     */
    public function scopeActive($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope a query to filter by pasarela name.
     */
    public function scopeByPasarela($query, $nombre)
    {
        return $query->where('nombre_pasarela', $nombre);
    }

    /**
     * Get pasarela display name.
     */
    public function getDisplayNameAttribute()
    {
        return match(strtolower($this->nombre_pasarela)) {
            'wompi' => 'Wompi',
            'payu' => 'PayU',
            'stripe' => 'Stripe',
            'mercadopago' => 'MercadoPago',
            'paypal' => 'PayPal',
            default => ucfirst($this->nombre_pasarela)
        };
    }

    /**
     * Get pasarela icon class.
     */
    public function getIconClassAttribute()
    {
        return match(strtolower($this->nombre_pasarela)) {
            'wompi' => 'bi-credit-card',
            'payu' => 'bi-credit-card-2-front',
            'stripe' => 'bi-stripe',
            'mercadopago' => 'bi-wallet2',
            'paypal' => 'bi-paypal',
            default => 'bi-credit-card'
        };
    }

    /**
     * Check if is sandbox mode.
     */
    public function isSandbox()
    {
        return isset($this->extra_config['sandbox']) && $this->extra_config['sandbox'] === true;
    }

    /**
     * Get environment badge.
     */
    public function getEnvironmentBadgeAttribute()
    {
        if ($this->isSandbox()) {
            return '<span class="badge bg-warning">Sandbox</span>';
        }
        return '<span class="badge bg-success">Producción</span>';
    }

    /**
     * Check if the gateway is active.
     */
    public function isActive(): bool
    {
        return (bool) $this->activo;
    }

    /**
     * Activate the gateway.
     */
    public function activate(): void
    {
        $this->update(['activo' => true]);
    }

    /**
     * Deactivate the gateway.
     */
    public function deactivate(): void
    {
        $this->update(['activo' => false]);
    }

    /**
     * Get the events key from extra config.
     */
    public function getEventsKey(): ?string
    {
        return $this->extra_config['events_key'] ?? null;
    }

    /**
     * Get the integrity key from extra config.
     */
    public function getIntegrityKey(): ?string
    {
        return $this->extra_config['integrity_key'] ?? null;
    }

    /**
     * Get the Wompi API URL based on environment.
     */
    public function getApiUrl(): string
    {
        if ($this->isSandbox()) {
            return 'https://sandbox.wompi.co/v1';
        }
        return 'https://production.wompi.co/v1';
    }

    /**
     * Get the Wompi Checkout URL based on environment.
     */
    public function getCheckoutUrl(): string
    {
        if ($this->isSandbox()) {
            return 'https://checkout.wompi.co/l';
        }
        return 'https://checkout.wompi.co/p';
    }
}