<?php

namespace App\Http\Controllers;

use App\Models\BbbRenovacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceiptController extends Controller
{
    /**
     * Descargar el recibo de una renovación específica
     */
    public function download(BbbRenovacion $renovacion)
    {
        // Verificar que la renovación pertenece al usuario autenticado
        if ($renovacion->user_id !== Auth::id()) {
            abort(403, 'No tienes acceso a este recibo.');
        }

        // Cargar las relaciones necesarias
        $renovacion->load(['user', 'plan', 'user.empresa']);

        // Datos para el PDF
        $data = [
            'renovacion' => $renovacion,
            'user' => $renovacion->user,
            'plan' => $renovacion->plan,
            'fecha_descarga' => now(),
        ];

        // Retornar la vista PDF limpia sin layout
        return view('receipts.pdf', $data);
    }

    /**
     * Obtener el último pago del usuario autenticado
     */
    public function downloadLatest()
    {
        $user = Auth::user();
        
        // Buscar la última renovación del usuario
        $renovacion = BbbRenovacion::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->with(['plan', 'user.empresa'])
            ->first();

        if (!$renovacion) {
            return redirect()->back()->with('error', 'No se encontraron pagos registrados.');
        }

        // Datos para el recibo
        $data = [
            'renovacion' => $renovacion,
            'user' => $renovacion->user,
            'plan' => $renovacion->plan,
            'fecha_descarga' => now(),
        ];

        return view('receipts.pdf', $data);
    }
}