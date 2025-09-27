# API de Notificaciones de Expiración de Licencias

## Endpoint para Cron Jobs

**URL:** `GET /api/licenses/process-notifications`
**Método:** GET
**Autenticación:** Bearer Token

### Headers Requeridos

```
Authorization: Bearer BBB_2025_API_TOKEN_SECURE_MAKE_INTEGRATION_d22e23f0ac21
Content-Type: application/json
```

### Ejemplo de uso con cURL

```bash
curl -X GET "https://bbbpaginasweb.com/api/licenses/process-notifications" \
  -H "Authorization: Bearer BBB_2025_API_TOKEN_SECURE_MAKE_INTEGRATION_d22e23f0ac21" \
  -H "Content-Type: application/json"
```

### Ejemplo de Cron Job

Agregar al crontab del servidor:

```bash
# Ejecutar notificaciones de expiración todos los días a las 9:00 AM
0 9 * * * curl -X GET "https://bbbpaginasweb.com/api/licenses/process-notifications" -H "Authorization: Bearer BBB_2025_API_TOKEN_SECURE_MAKE_INTEGRATION_d22e23f0ac21" >> /var/log/bbb-notifications.log 2>&1
```

### Ejemplo de Cron Job con wget

```bash
# Ejecutar notificaciones de expiración todos los días a las 9:00 AM
0 9 * * * wget --header="Authorization: Bearer BBB_2025_API_TOKEN_SECURE_MAKE_INTEGRATION_d22e23f0ac21" -O - "https://bbbpaginasweb.com/api/licenses/process-notifications" >> /var/log/bbb-notifications.log 2>&1
```

### Respuesta de Éxito

```json
{
  "success": true,
  "message": "Procesamiento de notificaciones completado",
  "timestamp": "2025-09-27 14:30:00",
  "timezone": "America/Bogota",
  "summary": {
    "notifications_sent": 3,
    "errors": 0,
    "processed_days": [5, 3, 1]
  },
  "notifications_sent": [
    {
      "success": true,
      "message": "Notificación enviada exitosamente",
      "user_id": 123,
      "user_name": "Juan Pérez",
      "user_email": "juan@ejemplo.com",
      "empresa": "Mi Empresa",
      "notification_type": "reminder_5_days",
      "days_remaining": 5,
      "license_type": "subscription",
      "expiration_date": "2025-10-02 14:30:00",
      "sent_at": "2025-09-27 14:30:00"
    }
  ],
  "errors": []
}
```

### Respuesta de Error - Token Inválido

```json
{
  "success": false,
  "message": "Token de autorización Bearer requerido",
  "error_code": "UNAUTHORIZED"
}
```

## Funcionamiento

1. **Verificación de Token**: Valida que el Bearer token coincida con `API_SECRET_TOKEN` del .env
2. **Zona Horaria**: Usa `America/Bogota` para cálculos de fechas
3. **Días de Notificación**: Procesa notificaciones para 5, 3 y 1 días antes de expiración
4. **Tipos de Licencia**: Maneja tanto trials como suscripciones
5. **Prevención de Duplicados**: Evita enviar la misma notificación múltiples veces
6. **Resumen al Admin**: Envía resumen de todas las notificaciones procesadas
7. **Logs**: Registra errores y actividad en los logs de Laravel

## Configuración del Servidor

### Variables de Entorno Requeridas

```env
API_SECRET_TOKEN=BBB_2025_API_TOKEN_SECURE_MAKE_INTEGRATION_d22e23f0ac21
```

### Configuración de Email

Asegurar que la configuración de email esté correcta en `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=tu-smtp-host
MAIL_PORT=587
MAIL_USERNAME=tu-username
MAIL_PASSWORD=tu-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@bbbpaginasweb.com
MAIL_FROM_NAME="BBB Páginas Web"
```

## Monitoreo

- **Logs**: Ver `/storage/logs/laravel.log` para errores
- **Base de Datos**: Tabla `license_notifications` registra todas las notificaciones
- **Email Admin**: Resumen automático enviado al email configurado en `config/app.php`

## Frecuencia Recomendada

- **Producción**: Una vez al día (9:00 AM Colombia)
- **Desarrollo**: Manual o cada hora para pruebas

## Seguridad

- Token Bearer obligatorio
- Validación contra valor en .env
- Sin exposición de datos sensibles en logs
- Rate limiting aplicado automáticamente por Laravel