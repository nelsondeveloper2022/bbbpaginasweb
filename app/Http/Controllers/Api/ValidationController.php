<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ValidationController extends Controller
{
    /**
     * Verificar disponibilidad de email
     */
    public function checkEmail(Request $request)
    {
        $email = $request->query('email');
        
        if (!$email) {
            return response()->json(['error' => 'Email requerido'], 400);
        }
        
        $exists = User::where('email', $email)->exists();
        
        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'Este email ya está registrado' : 'Email disponible'
        ]);
    }
}