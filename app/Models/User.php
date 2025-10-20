<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use App\Notifications\CustomResetPassword;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'movil',
        'idEmpresa',
        'id_plan',
        'empresa_nombre',
        'empresa_email',
        'empresa_direccion',
        'trial_ends_at',
        'free_trial_days',
        'emailValidado',
        'email_verification_token',
        'email_verification_sent_at',
        'subscription_starts_at',
        'subscription_ends_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'trial_ends_at' => 'datetime',
            'email_verification_sent_at' => 'datetime',
            'emailValidado' => 'boolean',
            'subscription_starts_at' => 'datetime',
            'subscription_ends_at' => 'datetime',
        ];
    }

    /**
     * Relación con la empresa
     */
    public function empresa()
    {
        return $this->belongsTo(BbbEmpresa::class, 'idEmpresa', 'idEmpresa');
    }

    /**
     * Relación con el plan
     */
    public function plan()
    {
        return $this->belongsTo(BbbPlan::class, 'id_plan', 'idPlan');
    }

    /**
     * Relación con las landings a través de la empresa
     */
    public function landings()
    {
        return $this->hasMany(BbbLanding::class, 'idEmpresa', 'idEmpresa');
    }

    /**
     * Verificar si el usuario está en periodo de prueba
     */
    public function isOnTrial()
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    /**
     * Verificar si el periodo de prueba ha expirado
     */
    public function trialExpired()
    {
        return $this->trial_ends_at && $this->trial_ends_at->isPast();
    }

    /**
     * Verificar si tiene el plan gratuito de 15 días
     */
    public function hasFreePlan()
    {
        return $this->id_plan == 6;
    }

    /**
     * Verificar si el plan actual ha expirado (para planes temporales)
     */
    public function currentPlanExpired()
    {
        if (!$this->plan) {
            return true;
        }

        // Planes permanentes (1, 2) nunca expiran
        if (in_array($this->id_plan, [1, 2]) && $this->plan->dias <= 0) {
            return false;
        }

        // Planes temporales verificar fecha de expiración
        if ($this->plan->dias > 0) {
            return $this->trial_ends_at && $this->trial_ends_at->isPast();
        }

        return false;
    }

    /**
     * Verificar si necesita renovar plan
     */
    public function needsPlanRenewal()
    {
        return $this->currentPlanExpired() || !$this->id_plan || $this->id_plan == 0;
    }

    /**
     * Verificar si tiene una suscripción activa
     */
    public function hasActiveSubscription()
    {
        return $this->id_plan && 
               $this->subscription_starts_at && 
               $this->subscription_ends_at && 
               $this->subscription_ends_at->isFuture();
    }

    /**
     * Verificar si la suscripción ha expirado
     */
    public function subscriptionExpired()
    {
        return $this->subscription_ends_at && $this->subscription_ends_at->isPast();
    }

    /**
     * Verificar si puede acceder a la plataforma
     */
    public function canAccessPlatform()
    {
        return $this->hasActiveSubscription() || $this->isOnTrial();
    }

    /**
     * Verificar si el plan está por vencer (próximos 5 días)
     */
    public function isPlanExpiringSoon()
    {
        if (!$this->trial_ends_at) {
            return false;
        }
        
        // Verificar si está entre hoy y los próximos 5 días
        $now = now();
        $fiveDaysFromNow = $now->copy()->addDays(5);
        
        return $this->trial_ends_at->between($now, $fiveDaysFromNow) && $this->trial_ends_at->isFuture();
    }

    /**
     * Verificar si tiene una licencia activa
     */
    public function hasActiveLicense()
    {
        return $this->hasActiveSubscription() || (!$this->trialExpired() && $this->isOnTrial());
    }

    /**
     * Relación con renovaciones
     */
    public function renovaciones()
    {
        return $this->hasMany(BbbRenovacion::class);
    }

    /**
     * Obtener la última renovación completada
     */
    public function lastRenovacion()
    {
        return $this->renovaciones()->completed()->latest()->first();
    }

    /**
     * Verificar si el perfil está completo
     */
    public function hasCompleteProfile()
    {
        return !empty($this->name) && 
               !empty($this->email) && 
               !empty($this->empresa_nombre) && 
               !empty($this->empresa_email);
    }

    /**
     * Obtener el porcentaje de completitud del perfil
     */
    public function getProfileCompletion()
    {
        $fields = [
            'name', 'email', 'movil',
            'empresa_nombre', 'empresa_email', 'empresa_direccion'
        ];
        
        $completed = 0;
        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $completed++;
            }
        }
        
        // La verificación de email es CRÍTICA y reduce significativamente el porcentaje
        $emailVerified = $this->isEmailVerified();
        if ($emailVerified) {
            $completed += 2; // Email verificado cuenta como 2 puntos extra
        }
        
        // Verificar campos de la empresa relacionada
        if ($this->empresa) {
            $empresaFields = [
                'facebook', 'instagram', 'linkedin', 'website'
            ];
            
            foreach ($empresaFields as $field) {
                if (!empty($this->empresa->$field)) {
                    $completed++;
                }
            }
            
            $totalFields = count($fields) + count($empresaFields) + 2; // +2 por email verificado
        } else {
            $totalFields = count($fields) + 2; // +2 por email verificado
        }
        
        $percentage = round(($completed / $totalFields) * 100);
        
        // Si el email no está verificado, el máximo es 70%
        if (!$emailVerified && $percentage > 70) {
            $percentage = 70;
        }
        
        return $percentage;
    }

    /**
     * Obtener detalles de completitud del perfil
     */
    public function getProfileCompletionDetails()
    {
        $details = [];
        
        if (!$this->isEmailVerified()) {
            $details[] = [
                'type' => 'critical',
                'message' => 'Email no verificado - REQUERIDO para publicar',
                'icon' => 'bi-shield-exclamation',
                'action' => 'Verificar email'
            ];
        }
        
        if (empty($this->name)) {
            $details[] = [
                'type' => 'warning',
                'message' => 'Nombre completo faltante',
                'icon' => 'bi-person',
                'action' => 'Agregar nombre'
            ];
        }
        
        if (empty($this->empresa_nombre)) {
            $details[] = [
                'type' => 'info',
                'message' => 'Información de empresa incompleta',
                'icon' => 'bi-building',
                'action' => 'Completar empresa'
            ];
        }
        
        return $details;
    }

    /**
     * Obtener el avatar del usuario (iniciales)
     */
    public function getAvatarAttribute()
    {
        return strtoupper(substr($this->name ?? 'U', 0, 1));
    }

    /**
     * Obtener el nombre completo de la empresa (con fallback)
     */
    public function getEmpresaNameAttribute()
    {
        return $this->empresa->nombre ?? $this->empresa_nombre ?? 'Mi Empresa';
    }

    /**
     * Verificar si tiene redes sociales configuradas
     */
    public function hasSocialMedia()
    {
        if (!$this->empresa) {
            return false;
        }
        
        return !empty($this->empresa->facebook) || 
               !empty($this->empresa->instagram) || 
               !empty($this->empresa->linkedin) || 
               !empty($this->empresa->twitter) || 
               !empty($this->empresa->tiktok) || 
               !empty($this->empresa->youtube);
    }

    /**
     * Verificar si el email está validado
     */
    public function isEmailVerified()
    {
        return $this->emailValidado === true;
    }

    /**
     * Verificar si se puede reenviar el email de verificación
     */
    public function canResendVerificationEmail()
    {
        if (!$this->email_verification_sent_at) {
            return true;
        }
        
        // Permitir reenvío cada 5 minutos
        return $this->email_verification_sent_at->addMinutes(5)->isPast();
    }

    /**
     * Generar token de verificación de email
     */
    public function generateEmailVerificationToken()
    {
        $this->email_verification_token = bin2hex(random_bytes(32));
        $this->email_verification_sent_at = now();
        $this->save();
        
        return $this->email_verification_token;
    }

    /**
     * Verificar si puede publicar la web (email verificado)
     */
    public function canPublishWebsite()
    {
        return $this->isEmailVerified() && $this->hasCompleteProfile();
    }

    /**
     * Send the password reset notification using the custom notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

    /**
     * Obtener el mensaje de estado de verificación
     */
    public function getVerificationStatusMessage()
    {
        if (!$this->isEmailVerified()) {
            return [
                'type' => 'warning',
                'message' => 'Tu email no está verificado. Verifica tu correo para poder publicar tu sitio web.',
                'action' => 'Verificar Email'
            ];
        }
        
        if (!$this->hasCompleteProfile()) {
            return [
                'type' => 'info',
                'message' => 'Completa tu perfil para poder publicar tu sitio web.',
                'action' => 'Completar Perfil'
            ];
        }
        
        return [
            'type' => 'success',
            'message' => '¡Todo listo! Tu cuenta está verificada y tu perfil está completo.',
            'action' => null
        ];
    }

    /**
     * Verificar si el usuario es administrador
     */
    public function isAdmin()
    {
        return $this->is_admin == 1;
    }

    /**
     * Verificar si el usuario puede ser impersonado
     */
    public function canBeImpersonated()
    {
        // No se puede impersonar a otros administradores
        if ($this->isAdmin()) {
            return false;
        }

        // Si ya tiene idEmpresa asignado (email validado), se puede impersonar
        if ($this->idEmpresa !== null) {
            return true;
        }

        // Si no tiene idEmpresa (email no validado), verificar si su empresa_nombre 
        // existe en la tabla bbbempresa
        if (!empty($this->empresa_nombre)) {
            $empresa = \App\Models\BbbEmpresa::where('nombre', $this->empresa_nombre)->first();
            if ($empresa) {
                return true;
            }
        }

        // Si no cumple ninguna condición, no se puede impersonar
        return false;
    }

    /**
     * Verificar si actualmente se está impersonando a este usuario
     */
    public function isBeingImpersonated()
    {
        return session()->has('impersonating_admin_id') && Auth::check() && Auth::user()->id === $this->id;
    }

    /**
     * Scope para obtener solo administradores
     */
    public function scopeAdmins($query)
    {
        return $query->where('is_admin', true);
    }

    /**
     * Scope para obtener solo usuarios regulares (no administradores)
     */
    public function scopeRegularUsers($query)
    {
        return $query->where('is_admin', false);
    }

    /**
     * Obtener el estado de la suscripción en formato legible
     */
    public function getSubscriptionStatusAttribute()
    {
        if ($this->isAdmin()) {
            return 'Administrador';
        }

        if ($this->subscription_ends_at && $this->subscription_ends_at->isFuture()) {
            return 'Activa';
        }

        if ($this->isOnTrial()) {
            return 'Trial';
        }

        return 'Expirada';
    }

    /**
     * Obtener días restantes de suscripción o trial
     */
    public function getDaysRemainingAttribute()
    {
        if ($this->isAdmin()) {
            return null;
        }

        if ($this->subscription_ends_at && $this->subscription_ends_at->isFuture()) {
            return (int) now()->diffInDays($this->subscription_ends_at);
        }

        if ($this->isOnTrial()) {
            return (int) now()->diffInDays($this->trial_ends_at);
        }

        return 0;
    }

    /**
     * Obtener la empresa asociada (por idEmpresa o por empresa_nombre)
     */
    public function getAssociatedEmpresa()
    {
        // Si tiene idEmpresa asignado (email validado), usar la relación existente
        if ($this->idEmpresa && $this->empresa) {
            return $this->empresa;
        }

        // Si no tiene idEmpresa (email no validado), buscar por empresa_nombre
        if (!empty($this->empresa_nombre)) {
            $empresa = \App\Models\BbbEmpresa::where('nombre', $this->empresa_nombre)->first();
            if ($empresa) {
                return $empresa;
            }
        }

        return null;
    }

    /**
     * Obtener información para impersonación
     */
    public function getImpersonationInfo()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'movil' => $this->movil,
            'empresa' => $this->empresa_nombre,
            'plan' => $this->plan->nombre ?? 'Sin plan',
            'status' => $this->subscription_status,
            'days_remaining' => $this->days_remaining,
            'can_be_impersonated' => $this->canBeImpersonated()
        ];
    }

}
