<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BbbPlan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bbbplan';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idPlan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idEmpresa',
        'nombre',
        'slug',
        'icono',
        'descripcion',
        'precioPesos',
        'preciosDolar',
        'dias',
        'orden',
        'destacado',
        'idioma',
        'aplicaProductos',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'precioPesos' => 'double',
        'preciosDolar' => 'double',
        'dias' => 'integer',
        'orden' => 'integer',
        'destacado' => 'boolean',
        'aplicaProductos' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the empresa that owns the plan.
     */
    public function empresa()
    {
        return $this->belongsTo(BbbEmpresa::class, 'idEmpresa', 'idEmpresa');
    }

    /**
     * Get the carritos for the plan.
     */
    public function carritos()
    {
        return $this->hasMany(BbbCarrito::class, 'idPlan', 'idPlan');
    }

    /**
     * Verificar si es un plan de arriendo (renovable)
     */
    public function isRenewable()
    {
        return $this->idPlan == 5 && $this->dias > 0;
    }

    /**
     * Verificar si es un plan one-time
     */
    public function isOneTime()
    {
        return in_array($this->idPlan, [1, 2]) || $this->dias <= 0;
    }

    /**
     * Obtener renovaciones relacionadas
     */
    public function renovaciones()
    {
        return $this->hasMany(BbbRenovacion::class, 'plan_id', 'idPlan');
    }

    /**
     * Get formatted price in COP.
     */
    public function getPrecioPesosFormateadoAttribute()
    {
        return format_cop_price($this->precioPesos);
    }

    /**
     * Get formatted price in USD.
     */
    public function getPreciosDolarFormateadoAttribute()
    {
        return format_usd_price($this->preciosDolar);
    }
}