<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BbbPlan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class PlanController extends Controller
{
    /**
     * Get plans by empresa ID
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getPlanesByEmpresa(Request $request): JsonResponse
    {
        try {
            // Validate the request
            $request->validate([
                'idEmpresa' => 'required|integer|min:1',
                'locale' => 'nullable|string|in:es,en'
            ]);

            $idEmpresa = $request->input('idEmpresa');
            $locale = $request->input('locale', 'es'); // Default to Spanish
            $idioma = $locale === 'en' ? 'english' : 'spanish';

            // Get plans for the empresa and language, ordered by 'orden' field
            $planes = BbbPlan::where('idEmpresa', $idEmpresa)
                ->where('idioma', $idioma)
                ->orderBy('orden', 'asc')
                ->orderBy('nombre', 'asc')
                ->get();

            // Transform the data to include only necessary fields
            $planesData = $planes->map(function ($plan) {
                return [
                    'idPlan' => $plan->idPlan,
                    'nombre' => $plan->nombre,
                    'descripcion' => $plan->descripcion,
                    'icono' => $plan->icono,
                    'precioPesos' => $plan->precioPesos,
                    'preciosDolar' => $plan->preciosDolar,
                    'orden' => $plan->orden,
                    'destacado' => $plan->destacado,
                    'slug' => $plan->slug,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Planes obtenidos correctamente',
                'data' => $planesData,
                'count' => $planesData->count(),
                'locale' => $locale,
                'idioma' => $idioma
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Datos de entrada inválidos',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Error getting planes by empresa: ' . $e->getMessage(), [
                'idEmpresa' => $request->input('idEmpresa'),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor al obtener los planes'
            ], 500);
        }
    }

    /**
     * Get specific plan by ID
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getPlanById(Request $request): JsonResponse
    {
        try {
            // Validate the request
            $request->validate([
                'idPlan' => 'required|integer|min:1'
            ]);

            $idPlan = $request->input('idPlan');

            // Get plan by ID
            $plan = BbbPlan::find($idPlan);

            if (!$plan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Plan no encontrado'
                ], 404);
            }

            $planData = [
                'idPlan' => $plan->idPlan,
                'idEmpresa' => $plan->idEmpresa,
                'nombre' => $plan->nombre,
                'descripcion' => $plan->descripcion,
                'icono' => $plan->icono,
                'precioPesos' => $plan->precioPesos,
                'preciosDolar' => $plan->preciosDolar,
                'orden' => $plan->orden,
                'destacado' => $plan->destacado,
                'created_at' => $plan->created_at,
                'updated_at' => $plan->updated_at,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Plan obtenido correctamente',
                'data' => $planData
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Datos de entrada inválidos',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Error getting plan by ID: ' . $e->getMessage(), [
                'idPlan' => $request->input('idPlan'),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor al obtener el plan'
            ], 500);
        }
    }
}