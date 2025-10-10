<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BbbCliente extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bbbclient';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'idCliente';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idEmpresa',
        'nombre',
        'email',
        'estado',
        'documento',
        'telefono',
        'fecha_nacimiento',
        'notas',
        'direccion'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'fecha_nacimiento' => 'date',
    ];

    /**
     * Get the empresa that owns the cliente.
     */
    public function empresa()
    {
        return $this->belongsTo(BbbEmpresa::class, 'idEmpresa', 'idEmpresa');
    }

    /**
     * Get the ventas for the cliente.
     */
    public function ventas()
    {
        return $this->hasMany(BbbVentaOnline::class, 'idCliente', 'idCliente');
    }

    /**
     * Scope a query to only include active clients.
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
     * Get the full name and email.
     */
    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' (' . $this->email . ')';
    }

    /**
     * Get the ventas online for the cliente.
     */
    public function ventasOnline()
    {
        return $this->hasMany(BbbVentaOnline::class, 'idCliente', 'idCliente');
    }

    /**
     * Scope a query to search clients by multiple fields.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('nombre', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('documento', 'like', "%{$search}%");
        });
    }
}