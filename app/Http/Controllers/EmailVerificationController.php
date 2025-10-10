<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Mail\EmailVerification;
use App\Models\User;

class EmailVerificationController extends Controller
{
    /**
     * Enviar email de verificación
     */
    public function sendVerificationEmail(Request $request)
    {
        $user = Auth::user();
        
        if ($user->isEmailVerified()) {
            return response()->json([
                'success' => false,
                'message' => 'Tu email ya está verificado.'
            ]);
        }
        
        // if (!$user->canResendVerificationEmail()) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Debes esperar 5 minutos antes de solicitar otro email de verificación.'
        //     ]);
        // }
        
        // Generar token
        $token = $user->generateEmailVerificationToken();
        
        try {
            // Enviar email
            Mail::to($user->email)->send(new EmailVerification($user, $token));
            
            return response()->json([
                'success' => true,
                'message' => 'Email de verificación enviado correctamente. Revisa tu bandeja de entrada.'
            ]);
        } catch (\Exception $e) {
            // Log del error para debugging
            Log::error('Error enviando email de verificación', [
                'user_id' => $user->id,
                'email' => $user->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el email. Por favor intenta nuevamente.',
                'debug' => config('app.debug') ? $e->getMessage() : null
            ]);
        }
    }
    
    /**
     * Verificar email con el token
     */
    public function verifyEmail($token)
    {
        $user = User::where('email_verification_token', $token)->first();
        
        if (!$user) {
            return redirect()->route('admin.profile.edit')->with('error', 'Token de verificación inválido.');
        }
        
        // Verificar si el token no ha expirado (24 horas)
        if ($user->email_verification_sent_at && $user->email_verification_sent_at->addHours(24)->isPast()) {
            return redirect()->route('admin.profile.edit')->with('error', 'El token de verificación ha expirado. Solicita uno nuevo.');
        }
        
        // Marcar email como verificado
        $user->emailValidado = true;
        $user->email_verification_token = null;
        $user->email_verification_sent_at = null;
        $user->save();
        
        return redirect()->route('admin.profile.edit')->with('success', '¡Email verificado correctamente! Ya puedes publicar tu sitio web.');
    }
    
    /**
     * Obtener estado de verificación para AJAX
     */
    public function getVerificationStatus()
    {
        $user = Auth::user();
        
        return response()->json([
            'verified' => $user->isEmailVerified(),
            'can_resend' => $user->canResendVerificationEmail(),
            'can_publish' => $user->canPublishWebsite(),
            'status_message' => $user->getVerificationStatusMessage()
        ]);
    }
}