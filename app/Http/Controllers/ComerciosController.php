<?php

namespace App\Http\Controllers;

use App\Models\BbbEmpresa;
use Illuminate\Http\Request;

class ComerciosController extends Controller
{
    /**
     * Catálogo de comercios activos (landing publicada + licencia vigente)
     */
    public function index(Request $request)
    {
        $query = BbbEmpresa::query()
            ->publicadas()
            ->conLicenciaVigente();

        // Filtros básicos
        if ($search = $request->get('q')) {
            $query->where('nombre', 'like', "%{$search}%");
        }
        if ($categoria = $request->get('categoria')) {
            // El proyecto no tiene categorías; se deja para futura expansión
            $query->where('categoria', $categoria); // si existiera la columna
        }
        if ($ciudad = $request->get('ciudad')) {
            // El proyecto no tiene ciudad; se deja para futura expansión
            $query->where('ciudad', $ciudad); // si existiera la columna
        }

        $comercios = $query->with(['landing'])
            ->orderBy('nombre')
            ->paginate(12)
            ->withQueryString();

        return view('comercios.index', compact('comercios'));
    }

    /**
     * Endpoint para obtener hasta 5 comercios activos para el slider
     */
    public function slider()
    {
        $comercios = BbbEmpresa::query()
            ->publicadas()
            ->conLicenciaVigente()
            ->with(['landing'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Responder JSON para el componente del home
        return response()->json([
            'success' => true,
            'data' => $comercios->map(function ($empresa) {
                return [
                    'nombre' => $empresa->nombre,
                    'slug' => $empresa->slug,
                    'logo' => $empresa->landing?->logo_url ? asset('storage/' . $empresa->landing->logo_url) : null,
                    'descripcion' => $empresa->landing?->descripcion,
                    'url' => $empresa->getLandingUrl(),
                ];
            })
        ]);
    }
}
