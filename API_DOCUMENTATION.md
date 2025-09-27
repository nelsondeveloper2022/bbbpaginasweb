# BBB Páginas Web - API Documentation

## Overview
Esta API proporciona acceso completo a todos los datos de licencias y usuarios de la plataforma BBB Páginas Web, especialmente diseñada para integración con Make.com y otros sistemas externos.

## Authentication
Todas las rutas de la API están protegidas mediante token de autorización.

### Token de Autorización
- **Header**: `Authorization`
- **Token**: `BBB_2025_API_TOKEN_SECURE_MAKE_INTEGRATION_d22e23f0ac21`

### Ejemplo de uso
```bash
curl -X GET "https://your-domain.com/api/licenses/all" \
  -H "Authorization: BBB_2025_API_TOKEN_SECURE_MAKE_INTEGRATION_d22e23f0ac21"
```

## Endpoints

### GET /api/licenses/all
Obtiene todas las licencias (usuarios) con información completa incluyendo empresa, plan, landing pages, renovaciones y métricas.

#### Response Structure
```json
{
  "success": true,
  "message": "Licencias obtenidas exitosamente",
  "timestamp": "2025-09-27 14:25:08",
  "statistics": {
    "total_users": 4,
    "admin_users": 2,
    "regular_users": 2,
    "verified_emails": 4,
    "active_subscriptions": 0,
    "on_trial": 2,
    "with_landing_pages": 2,
    "email_verification_rate": 100
  },
  "data": [
    {
      "user_id": 3,
      "name": "Nelson Moncada",
      "email": "nelson@bbbpaginasweb.com",
      "mobile": null,
      "is_admin": true,
      "email_verified": true,
      "registration_date": "2025-09-27 13:10:35",
      "last_update": "2025-09-27 13:10:35",
      "subscription": {
        "status": "Administrador",
        "starts_at": null,
        "ends_at": null,
        "days_remaining": null,
        "is_on_trial": false,
        "trial_ends_at": null,
        "free_trial_days": null
      },
      "plan": {
        "id": 6,
        "name": "Plan Free - 15 Días",
        "slug": "plan-free-15-dias",
        "price_cop": 0,
        "price_usd": 0,
        "duration_days": 15,
        "is_featured": false,
        "description": "Plan de prueba gratuito..."
      },
      "company": {
        "id": 6,
        "name": "Mi Empresa",
        "email": "empresa@ejemplo.com",
        "address": "Dirección de la empresa",
        "mobile": "3001234567",
        "whatsapp": "3001234567",
        "website": "https://miempresa.com",
        "slug": "mi-empresa",
        "status": "publicada",
        "social_media": {
          "facebook": "https://facebook.com/miempresa",
          "instagram": "https://instagram.com/miempresa",
          "linkedin": "https://linkedin.com/company/miempresa",
          "twitter": "https://twitter.com/miempresa",
          "tiktok": "https://tiktok.com/@miempresa",
          "youtube": "https://youtube.com/miempresa"
        },
        "has_social_media": true,
        "created_at": "2025-09-25 01:07:54",
        "updated_at": "2025-09-27 13:49:02"
      },
      "landing_pages": [
        {
          "id": 3,
          "title": "Mi Landing Page",
          "subtitle": "Subtítulo de la página",
          "description": "Descripción completa...",
          "objective": "captar_leads",
          "objective_description": "Descripción del objetivo...",
          "audience_description": "Descripción de la audiencia...",
          "audience_problems": "Problemas de la audiencia...",
          "audience_benefits": "Beneficios para la audiencia...",
          "primary_color": "#e0e40c",
          "secondary_color": "#0a0a0b",
          "style": "corporativo",
          "typography": "Montserrat",
          "logo_url": "http://localhost:8000/storage/landing/...",
          "media_count": 3,
          "media_files": [
            {
              "id": 8,
              "type": "imagen",
              "url": "http://localhost:8000/storage/landing/...",
              "description": "Descripción de la imagen"
            }
          ],
          "created_at": "2025-09-25 01:12:49",
          "updated_at": "2025-09-25 18:38:06"
        }
      ],
      "renewals": [
        {
          "id": 1,
          "amount": 50000,
          "currency": "COP",
          "status": "approved",
          "payment_method": "credit_card",
          "transaction_id": "txn_123456",
          "reference": "REF-001",
          "gateway": "wompi",
          "starts_at": "2025-10-01",
          "expires_at": "2025-11-01",
          "created_at": "2025-09-30 10:00:00"
        }
      ],
      "metrics": {
        "profile_completion": 67,
        "can_publish": true,
        "landing_count": 1,
        "renewal_count": 0,
        "active_subscription": false,
        "can_access_platform": true,
        "plan_expiring_soon": false
      }
    }
  ]
}
```

#### Data Fields Description

##### User Information
- `user_id`: ID único del usuario
- `name`: Nombre completo del usuario
- `email`: Email del usuario
- `mobile`: Número de teléfono móvil
- `is_admin`: Indica si el usuario es administrador
- `email_verified`: Estado de verificación del email
- `registration_date`: Fecha de registro
- `last_update`: Última actualización del perfil

##### Subscription Information
- `status`: Estado de la suscripción (Activa, Expirada, Trial, Administrador)
- `starts_at`: Fecha de inicio de suscripción
- `ends_at`: Fecha de expiración de suscripción
- `days_remaining`: Días restantes de suscripción
- `is_on_trial`: Indica si está en período de prueba
- `trial_ends_at`: Fecha de expiración del trial
- `free_trial_days`: Días de prueba gratuitos

##### Plan Information
- `id`: ID del plan
- `name`: Nombre del plan
- `slug`: Slug del plan
- `price_cop`: Precio en pesos colombianos
- `price_usd`: Precio en dólares americanos
- `duration_days`: Duración en días del plan
- `is_featured`: Indica si es un plan destacado
- `description`: Descripción del plan

##### Company Information
- `id`: ID de la empresa
- `name`: Nombre de la empresa
- `email`: Email de contacto de la empresa
- `address`: Dirección física
- `mobile`: Teléfono móvil de la empresa
- `whatsapp`: Número de WhatsApp
- `website`: Sitio web de la empresa
- `slug`: Slug único de la empresa
- `status`: Estado de la empresa (en_construccion, publicada, pausada)
- `social_media`: Objeto con todas las redes sociales
- `has_social_media`: Indica si tiene al menos una red social configurada
- `created_at`: Fecha de creación de la empresa
- `updated_at`: Última actualización de la empresa

##### Landing Pages
Array de objetos con información completa de cada landing page:
- `id`: ID de la landing page
- `title`: Título principal
- `subtitle`: Subtítulo
- `description`: Descripción general
- `objective`: Tipo de objetivo (captar_leads, vender_producto, construir_comunidad, etc.)
- `objective_description`: Descripción detallada del objetivo
- `audience_description`: Descripción de la audiencia objetivo
- `audience_problems`: Problemas que enfrenta la audiencia
- `audience_benefits`: Beneficios que ofrece la solución
- `primary_color`: Color principal en formato hex
- `secondary_color`: Color secundario en formato hex
- `style`: Estilo de diseño (moderno, corporativo, creativo, etc.)
- `typography`: Tipografía utilizada
- `logo_url`: URL del logo de la empresa
- `media_count`: Cantidad de archivos multimedia
- `media_files`: Array con información de cada archivo multimedia
- `created_at`: Fecha de creación
- `updated_at`: Última actualización

##### Renewals
Array con historial de renovaciones (últimas 5):
- `id`: ID de la renovación
- `amount`: Monto pagado
- `currency`: Moneda (COP, USD)
- `status`: Estado del pago (approved, pending, failed)
- `payment_method`: Método de pago utilizado
- `transaction_id`: ID de transacción del gateway
- `reference`: Referencia de pago
- `gateway`: Gateway de pago utilizado (wompi, etc.)
- `starts_at`: Fecha de inicio del período renovado
- `expires_at`: Fecha de expiración del período renovado
- `created_at`: Fecha de creación del registro

##### Metrics
Métricas calculadas del usuario:
- `profile_completion`: Porcentaje de completitud del perfil (0-100)
- `can_publish`: Indica si puede publicar su sitio web
- `landing_count`: Cantidad de landing pages creadas
- `renewal_count`: Cantidad total de renovaciones
- `active_subscription`: Indica si tiene suscripción activa
- `can_access_platform`: Indica si puede acceder a la plataforma
- `plan_expiring_soon`: Indica si el plan expira en menos de 7 días

#### Statistics Section
Resumen estadístico de todos los usuarios:
- `total_users`: Total de usuarios registrados
- `admin_users`: Cantidad de usuarios administradores
- `regular_users`: Cantidad de usuarios regulares
- `verified_emails`: Cantidad de emails verificados
- `active_subscriptions`: Cantidad de suscripciones activas
- `on_trial`: Cantidad de usuarios en período de prueba
- `with_landing_pages`: Cantidad de usuarios con landing pages
- `email_verification_rate`: Porcentaje de verificación de emails

## Error Responses

### Unauthorized (401)
```json
{
  "success": false,
  "message": "Token de autorización inválido o faltante",
  "error_code": "UNAUTHORIZED"
}
```

### Internal Server Error (500)
```json
{
  "success": false,
  "message": "Error interno del servidor",
  "error": "Detalle del error técnico",
  "error_code": "INTERNAL_SERVER_ERROR"
}
```

## Use Cases

### Make.com Integration
Esta API está especialmente diseñada para integración con Make.com, permitiendo:

1. **Automatización de seguimiento**: Monitorear usuarios que están por expirar
2. **Análisis de métricas**: Generar reportes automáticos de la plataforma
3. **Gestión de campañas**: Segmentar usuarios según sus características
4. **Notificaciones automáticas**: Enviar alertas basadas en el estado de las suscripciones
5. **Integración con CRM**: Sincronizar datos de clientes con sistemas externos

### Data Analysis Examples
```javascript
// Usuarios con planes por expirar
const expiringSoon = data.filter(user => user.metrics.plan_expiring_soon);

// Usuarios con alto completion rate pero sin landing pages
const potentialUpsell = data.filter(user => 
  user.metrics.profile_completion > 80 && 
  user.metrics.landing_count === 0
);

// Análisis de redes sociales por empresa
const socialMediaAnalysis = data.map(user => ({
  company: user.company.name,
  hasSocialMedia: user.company.has_social_media,
  platforms: Object.keys(user.company.social_media).filter(
    key => user.company.social_media[key]
  )
}));
```

## Rate Limiting
- Actualmente no hay límites de tasa implementados
- Se recomienda no hacer más de 10 requests por minuto para mantener el performance

## Security Notes
- El token debe mantenerse seguro y no debe ser compartido públicamente
- Todos los datos están cifrados en tránsito via HTTPS
- La API logs todas las requests para auditoría de seguridad

## Support
Para soporte técnico de la API, contactar:
- Email: nelson@bbbpaginasweb.com
- WhatsApp: +57 310 319 4738

---
*Documentación actualizada: 27 de Septiembre, 2025*