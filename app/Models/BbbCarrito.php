<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BbbCarrito extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bbbcarrito';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idCarrito';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idEmpresa',
        'sitioweb',
        'nombrecontacto',
        'email',
        'movil',
        'idPlan',
        'valorPagadoPesos',
        'valorPagadoDolar',
        'estado',
        'wompi_reference',
        'wompi_transaction_id',
        'payment_method',
        'fecha_pago',
        'wompi_processed_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'valorPagadoPesos' => 'double',
        'valorPagadoDolar' => 'double',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the empresa that owns the carrito.
     */
    public function empresa()
    {
        return $this->belongsTo(BbbEmpresa::class, 'idEmpresa', 'idEmpresa');
    }

    /**
     * Get the plan that belongs to the carrito.
     */
    public function plan()
    {
        return $this->belongsTo(BbbPlan::class, 'idPlan', 'idPlan');
    }

    /**
     * Get the bbbPlan that belongs to the carrito (alias for plan).
     */
    public function bbbPlan()
    {
        return $this->belongsTo(BbbPlan::class, 'idPlan', 'idPlan');
    }

    /**
     * Get the total price for the carrito.
     * Returns the price in the currency that was paid (COP or USD).
     */
    public function getPrecioTotalAttribute()
    {
        // Return the price in the currency that was used
        if ($this->valorPagadoPesos > 0) {
            return $this->valorPagadoPesos;
        }
        
        if ($this->valorPagadoDolar > 0) {
            return $this->valorPagadoDolar;
        }
        
        // Fallback to plan price if no valor was set
        if ($this->plan) {
            return $this->valorPagadoPesos > 0 ? $this->plan->precioPesos : $this->plan->preciosDolar;
        }
        
        return 0;
    }
}