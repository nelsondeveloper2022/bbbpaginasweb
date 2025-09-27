<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LicenseNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'license_id',
        'license_type',
        'expiration_date',
        'days_before_expiry',
        'notification_type',
        'email_sent_to',
        'email_content',
        'email_sent',
        'sent_at',
        'user_data',
    ];

    protected $casts = [
        'expiration_date' => 'date',
        'email_sent' => 'boolean',
        'sent_at' => 'datetime',
        'user_data' => 'array',
    ];

    // Tipos de notificación
    const TYPE_REMINDER_5_DAYS = 'reminder_5_days';
    const TYPE_REMINDER_3_DAYS = 'reminder_3_days';
    const TYPE_REMINDER_1_DAY = 'reminder_1_day';

    // Tipos de licencia
    const LICENSE_TYPE_TRIAL = 'trial';
    const LICENSE_TYPE_SUBSCRIPTION = 'subscription';

    /**
     * Relación con el usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scopes para consultas frecuentes
     */
    public function scopeSent($query)
    {
        return $query->where('email_sent', true);
    }

    public function scopePending($query)
    {
        return $query->where('email_sent', false);
    }

    public function scopeByNotificationType($query, $type)
    {
        return $query->where('notification_type', $type);
    }

    public function scopeByExpirationDate($query, $date)
    {
        return $query->whereDate('expiration_date', $date);
    }

    /**
     * Marcar como enviado
     */
    public function markAsSent()
    {
        $this->update([
            'email_sent' => true,
            'sent_at' => now(),
        ]);
    }

    /**
     * Obtener estadísticas de notificaciones
     */
    public static function getStats($startDate = null, $endDate = null)
    {
        $query = self::query();
        
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        return [
            'total_notifications' => $query->count(),
            'sent_notifications' => $query->where('email_sent', true)->count(),
            'pending_notifications' => $query->where('email_sent', false)->count(),
            'by_type' => $query->groupBy('notification_type')
                ->selectRaw('notification_type, count(*) as count')
                ->pluck('count', 'notification_type')
                ->toArray(),
            'by_license_type' => $query->groupBy('license_type')
                ->selectRaw('license_type, count(*) as count')
                ->pluck('count', 'license_type')
                ->toArray(),
        ];
    }
}
