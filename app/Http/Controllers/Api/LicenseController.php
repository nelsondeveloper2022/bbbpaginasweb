<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\BbbEmpresa;
use App\Models\BbbPlan;
use App\Models\BbbLanding;
use App\Models\BbbRenovacion;
use App\Models\LicenseNotification;
use App\Mail\LicenseExpirationReminder;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LicenseController extends Controller
{
    /**
     * Obtener todas las licencias (usuarios) con sus relaciones completas
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getAllLicenses(Request $request): JsonResponse
    {
        // Validar token de seguridad
        $providedToken = $request->header('Authorization') ?? $request->get('token');
        $expectedToken = env('API_SECRET_TOKEN');

        if (!$providedToken || $providedToken !== $expectedToken) {
            return response()->json([
                'success' => false,
                'message' => 'Token de autorización inválido o faltante',
                'error_code' => 'UNAUTHORIZED'
            ], 401);
        }

        try {
            // Obtener todos los usuarios (licencias) con sus relaciones
            $licenses = User::with([
                'empresa' => function($query) {
                    $query->select('*');
                },
                'plan' => function($query) {
                    $query->select('*');
                },
                'landings' => function($query) {
                    $query->select('*')->with('media');
                },
                'renovaciones' => function($query) {
                    $query->select('*')->latest()->limit(5);
                }
            ])
            ->select([
                'id',
                'name',
                'email',
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
                'subscription_starts_at',
                'subscription_ends_at',
                'created_at',
                'updated_at'
            ])
            ->get()
            ->map(function ($user) {
                return [
                    // Información básica del usuario
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'mobile' => $user->movil,
                    'is_admin' => $user->is_admin,
                    'email_verified' => $user->emailValidado,
                    'registration_date' => $user->created_at?->format('Y-m-d H:i:s'),
                    'last_update' => $user->updated_at?->format('Y-m-d H:i:s'),
                    
                    // Estado de suscripción
                    'subscription' => [
                        'status' => $user->subscription_status,
                        'starts_at' => $user->subscription_starts_at?->format('Y-m-d H:i:s'),
                        'ends_at' => $user->subscription_ends_at?->format('Y-m-d H:i:s'),
                        'days_remaining' => $user->days_remaining,
                        'is_on_trial' => $user->isOnTrial(),
                        'trial_ends_at' => $user->trial_ends_at?->format('Y-m-d H:i:s'),
                        'free_trial_days' => $user->free_trial_days,
                    ],
                    
                    // Información del plan
                    'plan' => $user->plan ? [
                        'id' => $user->plan->idPlan,
                        'name' => $user->plan->nombre,
                        'slug' => $user->plan->slug,
                        'price_cop' => $user->plan->precioPesos,
                        'price_usd' => $user->plan->preciosDolar,
                        'duration_days' => $user->plan->dias,
                        'is_featured' => $user->plan->destacado,
                        'description' => strip_tags($user->plan->descripcion ?? ''),
                    ] : null,
                    
                    // Información de la empresa
                    'company' => [
                        'id' => $user->idEmpresa,
                        'name' => $user->empresa?->nombre ?? $user->empresa_nombre,
                        'email' => $user->empresa?->email ?? $user->empresa_email,
                        'address' => $user->empresa?->direccion ?? $user->empresa_direccion,
                        'mobile' => $user->empresa?->movil,
                        'whatsapp' => $user->empresa?->whatsapp,
                        'website' => $user->empresa?->website,
                        'slug' => $user->empresa?->slug,
                        'status' => $user->empresa?->estado,
                        'social_media' => [
                            'facebook' => $user->empresa?->facebook,
                            'instagram' => $user->empresa?->instagram,
                            'linkedin' => $user->empresa?->linkedin,
                            'twitter' => $user->empresa?->twitter,
                            'tiktok' => $user->empresa?->tiktok,
                            'youtube' => $user->empresa?->youtube,
                        ],
                        'has_social_media' => $user->empresa?->hasSocialMedia() ?? false,
                        'created_at' => $user->empresa?->created_at?->format('Y-m-d H:i:s'),
                        'updated_at' => $user->empresa?->updated_at?->format('Y-m-d H:i:s'),
                    ],
                    
                    // Landing pages
                    'landing_pages' => $user->landings->map(function ($landing) {
                        return [
                            'id' => $landing->idLanding,
                            'title' => $landing->titulo_principal,
                            'subtitle' => $landing->subtitulo,
                            'description' => $landing->descripcion,
                            'objective' => $landing->objetivo,
                            'objective_description' => $landing->descripcion_objetivo,
                            'audience_description' => $landing->audiencia_descripcion,
                            'audience_problems' => $landing->audiencia_problemas,
                            'audience_benefits' => $landing->audiencia_beneficios,
                            'primary_color' => $landing->color_principal,
                            'secondary_color' => $landing->color_secundario,
                            'style' => $landing->estilo,
                            'typography' => $landing->tipografia,
                            'logo_url' => $landing->logo_url ? asset('storage/' . $landing->logo_url) : null,
                            'media_count' => $landing->media->count(),
                            'media_files' => $landing->media->map(function ($media) {
                                return [
                                    'id' => $media->idMedia,
                                    'type' => $media->tipo,
                                    'url' => asset('storage/' . $media->url),
                                    'description' => $media->descripcion,
                                ];
                            }),
                            'created_at' => $landing->created_at?->format('Y-m-d H:i:s'),
                            'updated_at' => $landing->updated_at?->format('Y-m-d H:i:s'),
                        ];
                    }),
                    
                    // Historial de renovaciones (últimas 5)
                    'renewals' => $user->renovaciones->map(function ($renovacion) {
                        return [
                            'id' => $renovacion->idRenovacion,
                            'amount' => $renovacion->amount,
                            'currency' => $renovacion->currency,
                            'status' => $renovacion->status,
                            'payment_method' => $renovacion->payment_method,
                            'transaction_id' => $renovacion->transaction_id,
                            'reference' => $renovacion->reference,
                            'gateway' => $renovacion->gateway,
                            'starts_at' => $renovacion->starts_at,
                            'expires_at' => $renovacion->expires_at,
                            'created_at' => $renovacion->created_at?->format('Y-m-d H:i:s'),
                        ];
                    }),
                    
                    // Métricas calculadas
                    'metrics' => [
                        'profile_completion' => $user->getProfileCompletion(),
                        'can_publish' => $user->canPublishWebsite(),
                        'landing_count' => $user->landings->count(),
                        'renewal_count' => $user->renovaciones->count(),
                        'active_subscription' => $user->hasActiveSubscription(),
                        'can_access_platform' => $user->canAccessPlatform(),
                        'plan_expiring_soon' => $user->isPlanExpiringSoon(),
                    ],
                ];
            });

            // Estadísticas generales
            $totalUsers = $licenses->count();
            $adminUsers = $licenses->where('is_admin', true)->count();
            $regularUsers = $totalUsers - $adminUsers;
            $verifiedEmails = $licenses->where('email_verified', true)->count();
            $activeSubscriptions = $licenses->where('metrics.active_subscription', true)->count();
            $onTrial = $licenses->where('subscription.is_on_trial', true)->count();
            $withLandings = $licenses->where('metrics.landing_count', '>', 0)->count();

            return response()->json([
                'success' => true,
                'message' => 'Licencias obtenidas exitosamente',
                'timestamp' => now()->format('Y-m-d H:i:s'),
                'statistics' => [
                    'total_users' => $totalUsers,
                    'admin_users' => $adminUsers,
                    'regular_users' => $regularUsers,
                    'verified_emails' => $verifiedEmails,
                    'active_subscriptions' => $activeSubscriptions,
                    'on_trial' => $onTrial,
                    'with_landing_pages' => $withLandings,
                    'email_verification_rate' => $totalUsers > 0 ? round(($verifiedEmails / $totalUsers) * 100, 2) : 0,
                ],
                'data' => $licenses
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor',
                'error' => $e->getMessage(),
                'error_code' => 'INTERNAL_SERVER_ERROR'
            ], 500);
        }
    }

    /**
     * API para procesar notificaciones de expiración de licencias
     * Este endpoint debe ser llamado por cron jobs del servidor
     * Método: GET con Authorization Bearer Token
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function processExpirationNotifications(Request $request): JsonResponse
    {
        // Validar token de seguridad Bearer
        $authHeader = $request->header('Authorization');
        $expectedToken = config('app.api.API_SECRET_TOKEN');

        // Extraer token del header Authorization Bearer
        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json([
                'success' => false,
                'message' => 'Token de autorización Bearer requerido',
                'error_code' => 'UNAUTHORIZED'
            ], 401);
        }

        $providedToken = substr($authHeader, 7); // Remover "Bearer "

        if (!$providedToken || $providedToken !== $expectedToken) {
            return response()->json([
                'success' => false,
                'message' => 'Token de autorización inválido',
                'error_code' => 'UNAUTHORIZED'
            ], 401);
        }

        try {
            // Configurar zona horaria de Colombia
            $colombiaTime = Carbon::now('America/Bogota');
            
            $notificationsSent = [];
            $errors = [];

            // Procesar notificaciones para 5 días, 3 días y 1 día
            $notificationDays = [5, 3, 1];

            foreach ($notificationDays as $days) {
                $targetDate = $colombiaTime->copy()->addDays($days)->toDateString();
                
                // Buscar usuarios con trial que expira en X días
                $usersWithExpiringTrial = User::where('trial_ends_at', '>=', $targetDate . ' 00:00:00')
                    ->where('trial_ends_at', '<=', $targetDate . ' 23:59:59')
                    ->where('is_admin', false)
                    ->get();

                // Buscar usuarios con suscripción que expira en X días
                $usersWithExpiringSubscription = User::where('subscription_ends_at', '>=', $targetDate . ' 00:00:00')
                    ->where('subscription_ends_at', '<=', $targetDate . ' 23:59:59')
                    ->where('is_admin', false)
                    ->get();

                // Procesar usuarios con trial expirando
                foreach ($usersWithExpiringTrial as $user) {
                    $result = $this->sendExpirationNotification($user, $days, 'trial');
                    if ($result['success']) {
                        $notificationsSent[] = $result;
                    } else {
                        $errors[] = $result;
                    }
                }

                // Procesar usuarios con suscripción expirando
                foreach ($usersWithExpiringSubscription as $user) {
                    $result = $this->sendExpirationNotification($user, $days, 'subscription');
                    if ($result['success']) {
                        $notificationsSent[] = $result;
                    } else {
                        $errors[] = $result;
                    }
                }
            }

            // Agregar delay para evitar límites de Mailtrap
            
            // Enviar resumen de notificaciones al admin (siempre, incluso si no hay notificaciones)
            $this->sendNotificationSummaryToAdmin($notificationsSent, $colombiaTime);

            return response()->json([
                'success' => true,
                'message' => 'Procesamiento de notificaciones completado',
                'timestamp' => $colombiaTime->format('Y-m-d H:i:s'),
                'timezone' => 'America/Bogota',
                'summary' => [
                    'notifications_sent' => count($notificationsSent),
                    'errors' => count($errors),
                    'processed_days' => $notificationDays,
                ],
                'notifications_sent' => $notificationsSent,
                'errors' => $errors,
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error in processExpirationNotifications: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor',
                'error' => $e->getMessage(),
                'error_code' => 'INTERNAL_SERVER_ERROR'
            ], 500);
        }
    }

    /**
     * Enviar notificación de expiración a un usuario específico
     */
    private function sendExpirationNotification(User $user, int $days, string $licenseType): array
    {
        try {
            $notificationType = match($days) {
                5 => LicenseNotification::TYPE_REMINDER_5_DAYS,
                3 => LicenseNotification::TYPE_REMINDER_3_DAYS,
                1 => LicenseNotification::TYPE_REMINDER_1_DAY,
                default => 'reminder_' . $days . '_days'
            };

            $expirationDate = $licenseType === 'subscription' ? $user->subscription_ends_at : $user->trial_ends_at;

            // Crear o actualizar registro de notificación
            $notification = LicenseNotification::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'notification_type' => $notificationType,
                    'expiration_date' => $expirationDate->toDateString(),
                ],
                [
                    'license_id' => (string) $user->id,
                    'license_type' => $licenseType,
                    'days_before_expiry' => $days,
                    'email_sent_to' => $user->email,
                    'user_data' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'empresa' => $user->empresa?->nombre ?? $user->empresa_nombre,
                        'plan' => $user->plan?->nombre ?? 'Plan Free',
                        'expiration_date' => $expirationDate->format('Y-m-d H:i:s'),
                    ],
                ]
            );

            // Enviar email
            Mail::to($user->email)->send(new LicenseExpirationReminder($user, $days, $licenseType));

            // Marcar como enviado
            $notification->markAsSent();

            return [
                'success' => true,
                'message' => 'Notificación enviada exitosamente',
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'empresa' => $user->empresa?->nombre ?? $user->empresa_nombre,
                'plan' => $user->plan?->nombre ?? 'Plan Free',
                'notification_type' => $notificationType,
                'days_remaining' => $days,
                'license_type' => $licenseType,
                'expiration_date' => $expirationDate->format('Y-m-d H:i:s'),
                'sent_at' => now()->format('Y-m-d H:i:s'),
            ];

        } catch (\Exception $e) {
            Log::error('Error sending expiration notification', [
                'user_id' => $user->id,
                'days' => $days,
                'license_type' => $licenseType,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Error al enviar notificación: ' . $e->getMessage(),
                'user_id' => $user->id,
                'notification_type' => $notificationType ?? 'unknown'
            ];
        }
    }

    /**
     * Enviar resumen de notificaciones al administrador
     */
    private function sendNotificationSummaryToAdmin(array $notifications, Carbon $processTime): void
    {
        try {
            $adminEmail = env('EMAIL_SOPORTE_CONTACTO', config('app.support.email'));
            
            Log::info('Admin notification process started', [
                'admin_email' => $adminEmail,
                'total_notifications' => count($notifications)
            ]);
            
            if (!$adminEmail) {
                Log::warning('No admin email configured for notification summary');
                return;
            }

            // Organizar datos por días de vencimiento
            $summary = [
                'total' => count($notifications),
                'process_time' => $processTime->format('d/m/Y H:i:s'),
                'accounts_expiring' => [
                    '5_days' => [],
                    '3_days' => [],
                    '1_day' => []
                ],
                'stats' => [
                    'total_5_days' => 0,
                    'total_3_days' => 0,
                    'total_1_day' => 0,
                    'trial_accounts' => 0,
                    'subscription_accounts' => 0
                ]
            ];

            // Si hay notificaciones, agruparlas por días restantes
            if (!empty($notifications)) {
                foreach ($notifications as $notification) {
                    $days = $notification['days_remaining'];
                    $account = [
                        'name' => $notification['user_name'],
                        'email' => $notification['user_email'],
                        'empresa' => $notification['empresa'] ?? 'Sin empresa',
                        'license_type' => $notification['license_type'],
                        'expiration_date' => $notification['expiration_date'],
                        'plan' => $notification['plan'] ?? 'Plan Free'
                    ];

                    // Organizar por días
                    if ($days == 5) {
                        $summary['accounts_expiring']['5_days'][] = $account;
                        $summary['stats']['total_5_days']++;
                    } elseif ($days == 3) {
                        $summary['accounts_expiring']['3_days'][] = $account;
                        $summary['stats']['total_3_days']++;
                    } elseif ($days == 1) {
                        $summary['accounts_expiring']['1_day'][] = $account;
                        $summary['stats']['total_1_day']++;
                    }

                    // Contar por tipo de licencia
                    if ($notification['license_type'] === 'trial') {
                        $summary['stats']['trial_accounts']++;
                    } else {
                        $summary['stats']['subscription_accounts']++;
                    }
                }
            }

            // Crear contenido HTML para el email
            Log::info('Generating admin summary HTML');
            $htmlContent = $this->generateAdminSummaryHTML($summary, $processTime);
            Log::info('Admin summary HTML generated successfully');

            // Enviar email al administrador
            Log::info('Attempting to send admin notification email', [
                'to' => $adminEmail,
                'subject' => 'Resumen de Notificaciones de Licencias - ' . $processTime->format('d/m/Y H:i')
            ]);
            
            Mail::raw('', function ($message) use ($adminEmail, $summary, $htmlContent, $processTime) {
                $message->to($adminEmail)
                    ->subject('Resumen de Notificaciones de Licencias - ' . $processTime->format('d/m/Y H:i'))
                    ->html($htmlContent);
            });

            Log::info('Notification summary sent to admin successfully', [
                'admin_email' => $adminEmail,
                'total_notifications' => $summary['total'],
                'process_time' => $processTime->format('Y-m-d H:i:s')
            ]);

        } catch (\Exception $e) {
            Log::error('Error sending notification summary to admin: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'admin_email' => $adminEmail ?? 'not_set',
                'summary_total' => $summary['total'] ?? 'not_set'
            ]);
        }
    }

    /**
     * Generar HTML para el resumen del administrador
     */
    private function generateAdminSummaryHTML(array $summary, Carbon $processTime): string
    {
        return view('emails.admin-notification-summary', [
            'summary' => $summary,
            'processTime' => $processTime,
            'supportEmail' => config('app.support.email'),
            'appUrl' => config('app.url'),
        ])->render();
    }

    /**
     * Obtener estadísticas de notificaciones enviadas
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function getNotificationStats(Request $request): JsonResponse
    {
        // Validar token de seguridad
        $providedToken = $request->header('Authorization') ?? $request->get('token');
        $expectedToken = env('API_SECRET_TOKEN');

        if (!$providedToken || $providedToken !== $expectedToken) {
            return response()->json([
                'success' => false,
                'message' => 'Token de autorización inválido o faltante',
                'error_code' => 'UNAUTHORIZED'
            ], 401);
        }

        try {
            $startDate = $request->get('start_date');
            $endDate = $request->get('end_date');

            $stats = LicenseNotification::getStats($startDate, $endDate);
            
            // Obtener notificaciones recientes
            $recentNotifications = LicenseNotification::with('user')
                ->sent()
                ->orderBy('sent_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($notification) {
                    return [
                        'id' => $notification->id,
                        'user_name' => $notification->user->name ?? 'Usuario eliminado',
                        'user_email' => $notification->email_sent_to,
                        'notification_type' => $notification->notification_type,
                        'license_type' => $notification->license_type,
                        'days_before_expiry' => $notification->days_before_expiry,
                        'expiration_date' => $notification->expiration_date->format('Y-m-d'),
                        'sent_at' => $notification->sent_at->format('Y-m-d H:i:s'),
                    ];
                });

            return response()->json([
                'success' => true,
                'message' => 'Estadísticas obtenidas exitosamente',
                'timestamp' => now()->format('Y-m-d H:i:s'),
                'filter' => [
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ],
                'statistics' => $stats,
                'recent_notifications' => $recentNotifications,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor',
                'error' => $e->getMessage(),
                'error_code' => 'INTERNAL_SERVER_ERROR'
            ], 500);
        }
    }
}
