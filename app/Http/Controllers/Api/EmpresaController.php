<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BbbEmpresa;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EmpresaController extends Controller
{
    /**
     * Get specific company information
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getEmpresa(Request $request): JsonResponse
    {
        try {
            $idEmpresa = $request->input('idEmpresa');

            if (!$idEmpresa) {
                return response()->json([
                    'success' => false,
                    'message' => 'idEmpresa is required'
                ], 400);
            }

            $empresa = BbbEmpresa::find($idEmpresa);

            if (!$empresa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Empresa not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $empresa
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving the empresa',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}