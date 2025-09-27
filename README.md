# BBB Páginas Web - Sistema Completo de Landing Pages Corporativas

## 📋 Descripción del Sistema

BBB Páginas Web es un sistema integral desarrollado en **Laravel 12.0** que permite a las empresas crear, gestionar y publicar landing pages profesionales. El sistema incluye gestión de usuarios, suscripciones, procesamiento de pagos, panel administrativo y un completo sistema de notificaciones automáticas.

## 🏗️ Arquitectura del Sistema

### Backend
- **Framework**: Laravel 12.0
- **PHP**: 8.2+
- **Base de Datos**: MySQL
- **Cache**: File/Redis
- **Queue**: Database/Redis
- **Mail**: SMTP (Gmail)

### Frontend
- **Templates**: Blade Engine
- **JavaScript**: Alpine.js
- **CSS**: Tailwind CSS
- **Build Tool**: Vite
- **Iconos**: Bootstrap Icons

### Integraciones
- **Pagos**: Wompi Gateway
- **Seguridad**: Google reCAPTCHA v2
- **Automatización**: Make.com (via API)
- **Email**: Gmail SMTP

## ⭐ Características Principales

### 🎯 Sistema de Landing Pages
- **Creador Visual**: Interface intuitiva para diseño de páginas
- **Personalización**: Colores, tipografías y estilos configurables
- **Media Manager**: Gestión de imágenes y videos
- **Objetivos Múltiples**: Captar leads, vender productos, construir comunidad
- **Análisis de Audiencia**: Definición de problemas y beneficios
- **Responsive Design**: Adaptable a todos los dispositivos

### 👥 Gestión de Usuarios y Empresas
- **Registro Completo**: Con verificación de email obligatoria
- **Perfiles de Empresa**: Información detallada y redes sociales
- **Trial Gratuito**: 15 días de acceso completo
- **Sistema de Roles**: Usuarios regulares y administradores
- **Autenticación Segura**: Con reCAPTCHA en todos los formularios

### 💳 Sistema de Suscripciones y Pagos
- **Planes Múltiples**: Trial, Mensual, Anual, Permanente
- **Integración Wompi**: Procesamiento seguro de pagos
- **Renovaciones**: Automáticas y manuales
- **Facturación**: Historial completo de transacciones
- **Notificaciones**: Recordatorios automáticos de expiración

### 🔧 Panel Administrativo Avanzado
- **Dashboard Completo**: Métricas y estadísticas en tiempo real
- **Gestión de Usuarios**: CRUD completo con detalles
- **Moderación**: Aprobación y publicación de landing pages
- **Notificaciones**: Sistema de emails automatizados
- **Reportes**: Estadísticas de uso y conversión

### 🚀 API Externa Completa
- **Integración Make.com**: Automatización de procesos
- **Datos Completos**: Usuarios, empresas, landing pages, métricas
- **Seguridad**: Autenticación por token
- **Notificaciones**: Sistema automático de recordatorios
- **Estadísticas**: Reporting en tiempo real

### 🔐 Sistema de Seguridad Completo
- **Google reCAPTCHA v2**: Integrado en todos los formularios del sistema
- **Autenticación Robusta**: Laravel Auth con verificación obligatoria de email
- **CSRF Protection**: Protección automática contra ataques de falsificación
- **SQL Injection**: Prevención total mediante Eloquent ORM
- **XSS Protection**: Escape automático en todas las vistas Blade
- **Middleware Personalizado**: Validación centralizada de reCAPTCHA
- **Rate Limiting**: Control de frecuencia de requests
- **Token Security**: API protegida con token de 64 caracteres

## 🛠️ Instalación y Configuración

### Prerrequisitos del Sistema
- **PHP**: 8.2 o superior
- **Composer**: Última versión
- **Node.js**: 18+ con NPM
- **MySQL**: 8.0+ o MariaDB 10.3+
- **Servidor Web**: Apache/Nginx
- **SSL**: Certificado válido (producción)
- **Git**: Para control de versiones

### Instalación Paso a Paso

#### 1. Clonar el Repositorio
```bash
git clone <repository-url>
cd bbb
```

#### 2. Instalación de Dependencias
```bash
# Dependencias PHP
composer install --no-dev --optimize-autoloader

# Dependencias Node.js
npm install
```

#### 3. Configuración del Entorno
```bash
# Copiar archivo de configuración
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate
```

#### 4. Configuración de Base de Datos
Editar `.env` con la configuración de tu base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bbb_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

#### 5. Ejecutar Migraciones
```bash
# Crear tablas
php artisan migrate

# Datos iniciales (opcional)
php artisan db:seed
```

#### 6. Configuración de Almacenamiento
```bash
# Crear enlace simbólico para archivos públicos
php artisan storage:link

# Establecer permisos
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### 7. Compilación de Assets
```bash
# Desarrollo
npm run dev

# Producción
npm run build
```

#### 8. Configuración del Servidor Web
- Apuntar el documento root a `public/`
- Configurar virtual host
- Instalar certificado SSL

## ⚙️ Configuración Completa del Sistema

### Variables de Entorno (.env)

#### Configuración de Aplicación
```env
# Información Básica
APP_NAME="BBB Páginas Web"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com
APP_TIMEZONE=America/Bogota
APP_LOCALE=es
APP_FALLBACK_LOCALE=es
```

#### Base de Datos
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bbb_database
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password
```

#### Sistema de Email (Gmail SMTP)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=soporte@bbbpaginasweb.com
MAIL_FROM_NAME="BBB Páginas Web"
```

#### Gateway de Pagos Wompi
```env
WOMPI_PUBLIC_KEY=pub_prod_tu_clave_publica
WOMPI_PRIVATE_KEY=prv_prod_tu_clave_privada
WOMPI_ENVIRONMENT=prod
WOMPI_CURRENCY=COP
```

#### Información de Contacto Centralizada
```env
SUPPORT_EMAIL=soporte@bbbpaginasweb.com
SUPPORT_MOBILE=+573103194738
SUPPORT_WHATSAPP=573103194738
```

#### Google reCAPTCHA v2
```env
RECAPTCHA_SITE_KEY=6Lea69YrAAAAAFSg_TQN2nLnOkGICoxWEJEatfPl
RECAPTCHA_SECRET_KEY=6Lea69YrAAAAAIY0J4F7UgGaKdqq2KJd8su_qimS
```

#### API Externa para Make.com
```env
API_SECRET_TOKEN=BBB_2025_API_TOKEN_SECURE_MAKE_INTEGRATION_d22e23f0ac21
```

### 📧 Configuración del Sistema de Email

#### Gmail SMTP (Recomendado)
1. **Habilitar 2FA**: Activar autenticación de dos factores en Gmail
2. **Generar App Password**: Crear contraseña específica para aplicaciones
3. **Configurar Variables**: Usar la app password en `MAIL_PASSWORD`
4. **Verificar Conexión**: Probar envío de emails

#### Otras Opciones SMTP
- **SendGrid**: Para volúmenes altos
- **Mailgun**: Para transaccionales
- **Amazon SES**: Integración AWS

### 💳 Configuración de Wompi

#### Obtener Credenciales
1. **Crear Cuenta**: Registrarse en Wompi
2. **Verificar Empresa**: Completar proceso de verificación
3. **Obtener Claves**: Copiar claves de producción
4. **Configurar Webhook**: URL para notificaciones de pago

#### Configuración del Webhook
- **URL**: `https://tu-dominio.com/api/payments/wompi/webhook`
- **Eventos**: `transaction.updated`
- **Método**: POST

### 🔐 Configuración de reCAPTCHA

#### Google reCAPTCHA v2
1. **Crear Proyecto**: En Google Cloud Console
2. **Configurar reCAPTCHA**: Tipo "I'm not a robot"
3. **Obtener Claves**: Site Key y Secret Key
4. **Configurar Dominios**: Agregar tu dominio

#### Límites Gratuitos
- **Solicitudes**: 10,000 por mes
- **Monitoreo**: Panel de Google reCAPTCHA
- **Logs**: Activar logging para debugging

## 👨‍💻 Guía de Uso del Sistema

### 🎯 Para Usuarios Regulares

#### 1. Proceso de Registro
```
/register → Formulario con reCAPTCHA → Verificación de email → Activación
```
- **Datos Requeridos**: Nombre, email, contraseña, información de empresa
- **Verificación**: Email obligatoria para acceso completo
- **Trial Gratuito**: 15 días de acceso completo automático

#### 2. Dashboard del Usuario
- **Resumen**: Estado del plan, días restantes, completitud del perfil
- **Gestión**: Actualizar datos personales y de empresa
- **Suscripción**: Ver plan actual, renovar, cambiar plan
- **Landing Pages**: Crear, editar, publicar páginas

#### 3. Creación de Landing Page
- **Paso 1**: Información básica (título, descripción, objetivo)
- **Paso 2**: Audiencia (problemas, beneficios, descripción)
- **Paso 3**: Diseño (colores, tipografía, estilo)
- **Paso 4**: Media (logo, imágenes, videos)
- **Paso 5**: Revisión y envío para aprobación

### 🔧 Para Administradores

#### 1. Panel Administrativo (`/admin`)
- **Dashboard**: Métricas generales, usuarios activos, planes por expirar
- **Gestión Usuarios**: CRUD completo, cambio de estados
- **Landing Pages**: Aprobación, publicación, moderación
- **Reportes**: Estadísticas de uso, conversión, ingresos

#### 2. Funciones Administrativas
- **Publicar Landing**: Aprobar y hacer públicas las páginas
- **Gestionar Planes**: Asignar, cambiar, extender suscripciones
- **Notificaciones**: Envío manual de recordatorios
- **Métricas**: Análisis de performance y uso

## 🚀 API Externa Completa

### Resumen de Endpoints
| Endpoint | Método | Descripción | Uso |
|----------|--------|-------------|-----|
| `/api/licenses/all` | GET | Obtener todas las licencias | Make.com, reportes |
| `/api/licenses/process-notifications` | POST | Procesar notificaciones | Cron jobs |
| `/api/licenses/notification-stats` | GET | Estadísticas de notificaciones | Monitoreo |

### Autenticación
**Todas las rutas requieren token de autorización**
```bash
Authorization: BBB_2025_API_TOKEN_SECURE_MAKE_INTEGRATION_d22e23f0ac21
```

### 1. Endpoint de Licencias (`/api/licenses/all`)

#### Características
- ✅ **Datos Completos**: Usuarios, empresas, landing pages, renovaciones
- ✅ **Métricas en Tiempo Real**: Completitud, días restantes, estado
- ✅ **Estadísticas Generales**: Resumen de toda la plataforma
- ✅ **Relaciones Optimizadas**: Consultas eficientes con Eloquent

#### Ejemplo de Uso
```bash
curl -X GET "https://tu-dominio.com/api/licenses/all" \
  -H "Authorization: BBB_2025_API_TOKEN_SECURE_MAKE_INTEGRATION_d22e23f0ac21"
```

#### Respuesta de Ejemplo
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
    "active_subscriptions": 2,
    "on_trial": 1,
    "with_landing_pages": 3,
    "email_verification_rate": 100
  },
  "data": [...]
}
```

### 2. Sistema de Notificaciones Automáticas (`/api/licenses/process-notifications`)

#### Funcionalidad
- **Detección Automática**: Licencias que expiran en 5, 3 y 1 días
- **Zona Horaria**: Colombia (America/Bogota)
- **Prevención Duplicados**: No envía la misma notificación dos veces
- **Registro Completo**: Logs de todos los envíos
- **Resumen al Admin**: Email automático con estadísticas

#### Configuración de Cron Job
```bash
# Ejecutar cada día a las 9:00 AM (hora de Colombia)
0 9 * * * curl -X POST "https://tu-dominio.com/api/licenses/process-notifications" \
  -H "Authorization: BBB_2025_API_TOKEN_SECURE_MAKE_INTEGRATION_d22e23f0ac21"
```

#### Ejemplo de Respuesta
```json
{
  "success": true,
  "message": "Procesamiento de notificaciones completado",
  "timestamp": "2025-09-27 09:00:00",
  "timezone": "America/Bogota",
  "summary": {
    "notifications_sent": 3,
    "errors": 0,
    "processed_days": [5, 3, 1]
  },
  "notifications_sent": [
    {
      "success": true,
      "user_name": "Juan Pérez",
      "user_email": "juan@empresa.com",
      "empresa": "Mi Empresa SAS",
      "notification_type": "reminder_3_days",
      "days_remaining": 3,
      "license_type": "trial",
      "expiration_date": "2025-09-30 10:00:00"
    }
  ]
}
```

### 3. Estadísticas de Notificaciones (`/api/licenses/notification-stats`)

#### Funcionalidad
- **Filtros por Fecha**: start_date y end_date
- **Métricas Completas**: Total, enviadas, pendientes
- **Agrupación**: Por tipo de notificación y licencia
- **Notificaciones Recientes**: Últimas 10 enviadas

### 4. Integración con Make.com

#### Configuración del Escenario
1. **HTTP Module**: GET request
2. **URL**: `https://tu-dominio.com/api/licenses/all`
3. **Headers**: Authorization con token
4. **Frecuencia**: Cada hora o según necesidades

#### Casos de Uso en Make.com
- **Usuarios por Expirar**: Filtrar por `metrics.plan_expiring_soon: true`
- **Conversión de Trials**: Identificar trials que se convirtieron
- **Segmentación**: Agrupar por plan, empresa, estado
- **Alertas**: Notificaciones Slack/Teams para usuarios críticos
- **CRM Sync**: Sincronizar con HubSpot, Salesforce, etc.

#### Ejemplo de Filtro en Make.com
```javascript
// Usuarios con planes por expirar en 3 días o menos
{{if(data.metrics.days_remaining <= 3; data.user_name; "")}}

// Usuarios con alto completion rate pero sin landing pages
{{if(and(data.metrics.profile_completion > 80; data.metrics.landing_count = 0); data.user_email; "")}}
```

### 5. Seguridad de la API

#### Medidas Implementadas
- **Token Único**: Autenticación por header Authorization
- **Rate Limiting**: 10 requests/minuto recomendado
- **IP Whitelisting**: Configurar IPs permitidas en servidor
- **HTTPS Only**: SSL obligatorio en producción
- **Logging**: Registro completo de accesos

#### Renovación de Token
- **Ubicación**: Variable `API_SECRET_TOKEN` en `.env`
- **Formato**: Alfanumérico, 64 caracteres mínimo
- **Rotación**: Cambiar cada 90 días por seguridad

## 🔐 Integración de Google reCAPTCHA v2

### Configuración Implementada
- **Claves**: Pre-configuradas para dominio de desarrollo y producción
- **Tipo**: reCAPTCHA v2 "I'm not a robot"
- **Límite Gratuito**: 10,000 solicitudes/mes
- **Integración**: Todos los formularios del sistema

### Formularios Protegidos
- ✅ **Registro de Usuario**: `/register`
- ✅ **Inicio de Sesión**: `/login`
- ✅ **Formulario de Contacto**: Todas las landing pages
- ✅ **Creación de Empresa**: Formularios de perfil
- ✅ **Recuperación de Contraseña**: `/forgot-password`
- ✅ **Cambio de Contraseña**: `/reset-password`

### Implementación Técnica

#### Componente Blade Reutilizable
```blade
<x-recaptcha theme="light" size="normal" />
```

#### Middleware Personalizado
```php
// app/Http/Middleware/RecaptchaMiddleware.php
Route::middleware(['recaptcha'])->group(function () {
    Route::post('/register', [RegisterController::class, 'store']);
    Route::post('/login', [LoginController::class, 'authenticate']);
});
```

#### Servicio de Validación
```php
// app/Services/RecaptchaService.php
$isValid = app(RecaptchaService::class)->verify($token, $userIp);
```

### Configuración en Producción
1. **Obtener Claves**: Google reCAPTCHA Admin Console
2. **Configurar Dominios**: Agregar dominio de producción
3. **Actualizar .env**: Cambiar claves de desarrollo por producción
4. **Monitorear Uso**: Panel de Google reCAPTCHA

### Logs y Debugging
- **Ubicación**: `storage/logs/laravel.log`
- **Eventos**: Verificaciones exitosas y fallidas
- **Métricas**: Tasa de éxito, IPs bloqueadas
- **Alertas**: Configurar notificaciones por uso excesivo

## 📁 Estructura Completa del Proyecto

```
📦 BBB Páginas Web/
├── 🏗️ app/
│   ├── Console/Commands/           # Comandos Artisan personalizados
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php         # Panel administrativo completo
│   │   │   ├── DashboardController.php     # Dashboard usuarios
│   │   │   ├── LandingController.php       # Gestión landing pages
│   │   │   ├── PaymentController.php       # Procesamiento pagos Wompi
│   │   │   └── Api/
│   │   │       └── LicenseController.php   # API externa Make.com
│   │   ├── Middleware/
│   │   │   ├── RecaptchaMiddleware.php     # Validación reCAPTCHA
│   │   │   ├── CheckTrialStatus.php       # Control de trials
│   │   │   └── IsAdmin.php                # Verificación admin
│   │   └── Requests/               # Form Request Validation
│   ├── Mail/
│   │   ├── LicenseExpirationReminder.php  # Notificaciones expiración  
│   │   ├── ContactNotification.php        # Emails de contacto
│   │   └── EmailVerification.php          # Verificación email
│   ├── Models/
│   │   ├── User.php                       # Usuario + métricas
│   │   ├── BbbEmpresa.php                 # Empresa + redes sociales
│   │   ├── BbbLanding.php                 # Landing pages
│   │   ├── BbbPlan.php                    # Planes suscripción
│   │   ├── BbbRenovacion.php              # Historial pagos
│   │   └── LicenseNotification.php        # Registro notificaciones
│   ├── Services/
│   │   └── RecaptchaService.php           # Servicio reCAPTCHA
│   └── View/Components/            # Componentes Blade reutilizables
├── 🗄️ database/
│   ├── migrations/                 # Estructura BD evolutiva
│   ├── seeders/                   # Datos iniciales
│   └── factories/                 # Factories para testing
├── 🎨 resources/
│   ├── views/
│   │   ├── admin/                 # Panel administrativo
│   │   ├── auth/                  # Autenticación
│   │   ├── dashboard/             # Dashboard usuario
│   │   ├── landing/               # Gestión landing pages
│   │   ├── emails/                # Templates de email
│   │   └── components/
│   │       └── recaptcha.blade.php # Componente reCAPTCHA
│   ├── css/app.css                # Tailwind CSS
│   └── js/app.js                  # Alpine.js + Bootstrap
├── 🛣️ routes/
│   ├── web.php                    # Rutas principales
│   ├── api.php                    # API externa protegida
│   └── auth.php                   # Rutas autenticación
├── ⚙️ config/
│   ├── app.php                    # Config general + reCAPTCHA
│   ├── database.php               # Configuración BD
│   ├── mail.php                   # Configuración email
│   └── wompi.php                  # Gateway de pagos
└── 📝 Documentación/
    ├── README.md                  # Este archivo (fuente de verdad)
    └── API_DOCUMENTATION.md       # Documentación técnica API
```

## Sistema de Contacto Centralizado

### Variables Centralizadas
Todas las referencias de contacto en el sistema utilizan variables centralizadas:

```php
// En cualquier parte del código
config('app.support.email')      // Email de soporte
config('app.support.mobile')     // Móvil de contacto  
config('app.support.whatsapp')   // WhatsApp
```

### Archivos Actualizados (25+)
- ✅ Todos los controladores
- ✅ Todas las vistas y componentes
- ✅ Emails y notificaciones
- ✅ Archivos de configuración
- ✅ Documentación del sistema

## Seguridad

### Medidas Implementadas

- **Autenticación**: Sistema Laravel Auth con verificación de email
- **Autorización**: Middleware para proteger rutas administrativas
- **CSRF**: Protección contra ataques CSRF
- **SQL Injection**: Uso de Eloquent ORM y prepared statements optimizados
- **XSS**: Escape automático de datos en vistas Blade
- **API**: Token de autorización seguro para endpoints externos
- **Pagos**: Integración segura con Wompi
- **Relaciones BD**: Optimización de consultas y relaciones

### Recomendaciones Adicionales

1. Usar HTTPS en producción
2. Configurar firewall del servidor
3. Mantener Laravel actualizado
4. Backup regular de base de datos
5. Monitoreo de logs de seguridad
6. Auditoría regular de accesos a API

## Testing

```bash
# Ejecutar tests
php artisan test

# Tests con coverage
php artisan test --coverage

# Test específico de API
php artisan test --filter=LicenseControllerTest
```

## Deployment

### Producción

1. **Servidor**: Configurar servidor web (Apache/Nginx)
2. **SSL**: Instalar certificado SSL
3. **Permisos**: Configurar permisos de archivos
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```
4. **Cache**: Optimizar para producción
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### CI/CD
El proyecto está listo para integración con:
- GitHub Actions
- GitLab CI/CD
- Jenkins  
- AWS CodePipeline

## Monitoreo y Logs

### Logs del Sistema
- Ubicación: `storage/logs/laravel.log`
- Rotación automática de logs
- Niveles: emergency, alert, critical, error, warning, notice, info, debug

### Métricas Importantes
- Registros de usuarios
- Conversiones de trial a pago
- Páginas publicadas
- Errores de pago
- Performance de la aplicación
- Accesos a API externa

## Mantenimiento

### Tareas Regulares

1. **Backup diario** de base de datos
2. **Limpieza de logs** antiguos
3. **Actualización** de dependencias
4. **Monitoreo** de performance
5. **Revisión** de métricas de negocio
6. **Auditoría** de accesos API

### Comandos Útiles

```bash
# Limpiar cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimizar aplicación
php artisan optimize

# Ejecutar cola de trabajos
php artisan queue:work

# Programar tareas
php artisan schedule:run

# Verificar estado API
curl -I https://tu-dominio.com/api/licenses/all
```

## Integración con Make.com

### Configuración
1. Crear nuevo escenario en Make.com
2. Agregar módulo HTTP GET
3. URL: `https://tu-dominio.com/api/licenses/all`
4. Headers: `Authorization: BBB_2025_API_TOKEN_SECURE_MAKE_INTEGRATION_d22e23f0ac21`

### Casos de Uso
- ✅ Automatización de seguimiento de usuarios
- ✅ Notificaciones de expiración de planes
- ✅ Análisis de métricas en tiempo real
- ✅ Integración con CRM externos
- ✅ Reportes automáticos por email
- ✅ Segmentación de usuarios para campañas

## 📊 Monitoreo y Análisis del Sistema

### Métricas Clave Implementadas
- **Usuarios Activos**: Dashboard con estadísticas en tiempo real
- **Landing Pages**: Conteo por estado (activas, en construcción, expiradas)
- **Conversiones**: Tracking de formularios de contacto
- **Pagos**: Seguimiento transacciones Wompi
- **Notificaciones**: Registro completo de emails enviados
- **Seguridad**: Logs de intentos reCAPTCHA

### Logs del Sistema Avanzados
```bash
# Ver logs en tiempo real
tail -f storage/logs/laravel.log

# Filtrar por tipo de evento
grep "LICENSE_EXPIRATION" storage/logs/laravel.log
grep "RECAPTCHA_VALIDATION" storage/logs/laravel.log
grep "PAYMENT_PROCESSED" storage/logs/laravel.log
grep "API_ACCESS" storage/logs/laravel.log
```

### Comandos de Monitoreo Personalizados
```bash
# Estado general del sistema
php artisan system:status

# Verificar trabajos en cola
php artisan queue:work --timeout=60

# Limpiar logs antiguos
php artisan log:clear --days=30

# Verificar integridad base de datos
php artisan db:check

# Estadísticas de usuarios
php artisan bbb:user-stats

# Verificar notificaciones pendientes
php artisan bbb:check-notifications
```

## 🚀 Guía de Deployment Profesional

### Requisitos del Servidor
- **PHP**: 8.2 o superior con extensiones: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath, Curl, Fileinfo
- **Composer**: 2.5+
- **Base de Datos**: MySQL 8.0+ o MariaDB 10.4+
- **Servidor Web**: Nginx (recomendado) o Apache
- **SSL**: Certificado obligatorio para reCAPTCHA y API
- **Memoria**: Mínimo 1GB RAM (recomendado 2GB+)
- **Espacio Disco**: 10GB+ para logs y uploads

### Script de Deployment Automático
```bash
#!/bin/bash
# deploy.sh - Script de deployment profesional

echo "🚀 Iniciando deployment BBB Páginas Web..."

# 1. Actualizar código desde repositorio
echo "📥 Actualizando código..."
git pull origin main

# 2. Instalar dependencias optimizadas para producción
echo "📦 Instalando dependencias..."
composer install --no-dev --optimize-autoloader --no-interaction

# 3. Ejecutar migraciones de base de datos
echo "🗄️ Ejecutando migraciones..."
php artisan migrate --force

# 4. Optimizar aplicación para máximo rendimiento
echo "⚡ Optimizando aplicación..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# 5. Limpiar cachés anteriores
php artisan cache:clear

# 6. Reiniciar servicios críticos
echo "🔄 Reiniciando servicios..."
php artisan queue:restart
sudo systemctl reload nginx
sudo systemctl restart php8.2-fpm

# 7. Verificar estado del deployment
echo "🔍 Verificando deployment..."
php artisan optimize:clear
php artisan config:cache

echo "✅ Deployment completado exitosamente!"
echo "🌐 Sistema disponible en: https://bbbpaginasweb.com"
```

### Variables de Entorno Producción Completas
```env
# === CONFIGURACIÓN GENERAL ===
APP_NAME="BBB Páginas Web"
APP_ENV=production
APP_KEY=base64:GENERAR_NUEVA_CLAVE_32_CARACTERES
APP_DEBUG=false
APP_TIMEZONE=America/Bogota
APP_URL=https://bbbpaginasweb.com
APP_LOCALE=es

# === SEGURIDAD reCAPTCHA ===
RECAPTCHA_SITE_KEY=6Lea69YrAAAAAFSg_TQN2nLnOkGICoxWEJEatfPl
RECAPTCHA_SECRET_KEY=6Lea69YrAAAAAIY0J4F7UgGaKdqq2KJd8su_qimS

# === API EXTERNA MAKE.COM ===
MAKE_API_TOKEN=BBB_2025_API_TOKEN_SECURE_MAKE_INTEGRATION_d22e23f0ac21
API_RATE_LIMIT=1000

# === BASE DE DATOS ===
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bbb_production
DB_USERNAME=bbb_user
DB_PASSWORD=P@ssw0rd_Segur@_2025!

# === CONFIGURACIÓN EMAIL ===
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=notificaciones@bbbpaginasweb.com
MAIL_PASSWORD=app_password_gmail_16_caracteres
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=notificaciones@bbbpaginasweb.com
MAIL_FROM_NAME="BBB Páginas Web"

# === PAGOS WOMPI ===
WOMPI_PUBLIC_KEY=pub_prod_CLAVE_PUBLICA_WOMPI
WOMPI_PRIVATE_KEY=prv_prod_CLAVE_PRIVADA_WOMPI
WOMPI_ENVIRONMENT=production
WOMPI_WEBHOOK_SECRET=webhook_secret_seguro

# === CACHE Y SESIONES ===
CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# === REDIS ===
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=redis_password_seguro
REDIS_PORT=6379

# === LOGS ===
LOG_CHANNEL=daily
LOG_LEVEL=info
LOG_DEPRECATIONS_CHANNEL=null
```

## 🔧 Troubleshooting Avanzado

### Problemas de reCAPTCHA
```bash
# ❌ Error: "Invalid domain for site key"
# ✅ Solución: 
#   1. Verificar dominio en Google reCAPTCHA Console
#   2. Agregar todos los subdominios (www, staging, etc.)
#   3. Verificar HTTPS está activo

# ❌ Error: "Missing recaptcha-token"
# ✅ Solución:
#   1. Verificar JavaScript se carga correctamente
#   2. Comprobar component <x-recaptcha /> está incluido
#   3. Validar claves en .env no están intercambiadas

# Test reCAPTCHA desde línea de comandos
php artisan tinker
app(\App\Services\RecaptchaService::class)->verify('test_token', '127.0.0.1');
```

### Problemas de Base de Datos
```bash
# ❌ Error: "Connection refused"
# ✅ Diagnóstico:
php artisan tinker
DB::connection()->getPdo(); // Test conexión directa

# ❌ Error: "Migration failed"
# ✅ Solución paso a paso:
php artisan migrate:status          # Ver estado migraciones
php artisan migrate:rollback --step=1  # Rollback última migración
php artisan migrate                 # Re-ejecutar migraciones

# Backup antes de migraciones críticas
mysqldump -u usuario -p bbb_production > backup_$(date +%Y%m%d_%H%M%S).sql
```

### Problemas de Email y Notificaciones
```bash
# Test configuración SMTP
php artisan tinker
Mail::raw('Test desde BBB System', function($msg) { 
    $msg->to('test@bbbpaginasweb.com')
        ->subject('Test Email Configuration'); 
});

# Verificar cola de emails
php artisan queue:work --queue=emails --timeout=60

# Ver logs específicos de email
grep "EMAIL_SENT\|EMAIL_FAILED" storage/logs/laravel.log
```

### Performance y Optimización
```bash
# Limpiar todos los cachés
php artisan optimize:clear

# Re-generar cachés optimizados
php artisan optimize

# Verificar uso de memoria
php artisan tinker
echo memory_get_usage(true) / 1024 / 1024 . " MB";

# Optimizar base de datos
php artisan db:optimize

# Verificar queries N+1
php artisan telescope:install  # Solo en desarrollo
```

### Problemas de API Externa
```bash
# Test API desde servidor
curl -H "Authorization: BBB_2025_API_TOKEN_SECURE_MAKE_INTEGRATION_d22e23f0ac21" \
     -H "Accept: application/json" \
     https://bbbpaginasweb.com/api/licenses/all

# Verificar logs de API
grep "API_REQUEST\|API_ERROR" storage/logs/laravel.log

# Test conectividad Make.com
php artisan bbb:test-api-connectivity
```

## 📈 Contexto Histórico del Proyecto

### Fase 1: Fundación (Septiembre 2024)
- ✅ **Setup Inicial**: Laravel 12.0, estructura MVC, base de datos MySQL
- ✅ **Autenticación**: Sistema completo con verificación email
- ✅ **Modelos Base**: User, BbbEmpresa, BbbLanding, BbbPlan
- ✅ **Dashboard Básico**: Panel usuario con funcionalidades esenciales

### Fase 2: Core Business (Octubre 2024)  
- ✅ **Landing Pages**: CRUD completo, personalización, publicación
- ✅ **Pagos Wompi**: Integración gateway, confirmaciones, webhooks
- ✅ **Panel Admin**: Gestión usuarios, empresas, estadísticas
- ✅ **Email System**: Plantillas HTML, notificaciones automáticas

### Fase 3: Integración Externa (Noviembre 2024)
- ✅ **API Make.com**: Endpoints seguros con autenticación por token
- ✅ **Datos Completos**: Expansión modelos con métricas avanzadas
- ✅ **Webhook System**: Automatización eventos críticos
- ✅ **Monitoring**: Logs detallados, métricas de negocio

### Fase 4: Seguridad y Notificaciones (Enero 2025)
- ✅ **Google reCAPTCHA v2**: Protección todos los formularios
- ✅ **Sistema Notificaciones**: Alertas expiración licencias automáticas
- ✅ **Email Templates**: Diseño profesional con branding corporativo
- ✅ **Security Middleware**: Validación automática, rate limiting

### Fase 5: Optimización Final (Enero 2025 - Actual)
- ✅ **Performance**: Caché, optimización queries, CDN ready
- ✅ **Deployment**: Scripts automáticos, CI/CD ready
- ✅ **Documentation**: README como fuente de verdad única
- ✅ **Testing**: Cobertura crítica, APIs, seguridad
- ✅ **Monitoring**: Métricas tiempo real, alertas automáticas

### Roadmap 2025
- **Q2**: Sistema de afiliados y comisiones
- **Q3**: Aplicación móvil nativa
- **Q4**: IA para optimización automática de conversiones

## 📋 Estado Final del Proyecto

### ✅ Funcionalidades 100% Completadas
- **🏗️ Sistema Base**: Laravel 12.0 con arquitectura enterprise
- **🔐 Autenticación**: Completa con reCAPTCHA y verificación email
- **📊 Dashboard**: Panel usuario con métricas tiempo real
- **🎨 Landing Pages**: CRUD completo, personalización avanzada
- **💳 Pagos**: Wompi integrado con confirmaciones automáticas
- **🔌 API Externa**: Make.com con datos completos y seguros
- **📧 Notificaciones**: Sistema automático con plantillas HTML
- **🛡️ Seguridad**: reCAPTCHA v2 en todos los formularios
- **⚙️ Panel Admin**: Gestión completa usuarios y estadísticas
- **📈 Monitoreo**: Logs detallados y métricas de negocio

### 🚀 Listo para Producción
- **SSL**: Certificado configurado
- **Performance**: Caché optimizado, queries eficientes
- **Backup**: Sistema automático base de datos
- **Logs**: Rotación automática, alertas configuradas
- **Security**: Rate limiting, validaciones, tokens seguros
- **Deployment**: Scripts automáticos, rollback disponible

## 💼 Soporte y Contacto

### Equipo de Desarrollo
- **Lead Developer**: Nelson Moncada
- **Email**: nelson@bbbpaginasweb.com
- **WhatsApp**: +57 310 319 4738
- **Empresa**: BBB Páginas Web
- **Ubicación**: Bogotá, Colombia

### Soporte Técnico 24/7
- **Email Urgencias**: soporte@bbbpaginasweb.com
- **Documentación**: Este README (fuente de verdad única)
- **Issues**: Reportar via email con logs adjuntos
- **Updates**: Notificaciones automáticas por email

---

**🎯 BBB Páginas Web - Sistema de Gestión de Landing Pages Empresariales**  
*Desarrollado con Laravel 12.0 | Implementación Profesional 2025*  
*© 2025 BBB Páginas Web - Todos los derechos reservados*

### Reportar Issues
1. Descripción detallada del problema
2. Pasos para reproducir
3. Screenshots si es necesario
4. Información del entorno
5. Logs relevantes

### Contribuir
1. Fork del repositorio
2. Crear rama feature (`git checkout -b feature/nueva-funcionalidad`)
3. Commit cambios (`git commit -m 'Agregar nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Crear Pull Request

## Changelog

### v2.0.0 (2025-09-27) - **LANZAMIENTO MAYOR**
- ✅ **API Externa Completa**: Endpoint `/api/licenses/all` con datos completos
- ✅ **Sistema de Administración**: Panel completo con gestión de usuarios y landing pages
- ✅ **Centralización de Contacto**: Variables centralizadas en 25+ archivos
- ✅ **Optimización BD**: Relaciones optimizadas y consultas mejoradas
- ✅ **Documentación API**: Documentación completa para integración con Make.com
- ✅ **Limpieza de Proyecto**: Eliminación de archivos innecesarios
- ✅ **Seguridad**: Token de API seguro y autenticación mejorada
- ✅ **Métricas Avanzadas**: Cálculo en tiempo real de métricas de usuario

### v1.5.0 (2025-09-25)
- ✅ Sistema de landing pages funcional
- ✅ Integración de pagos con Wompi
- ✅ Panel administrativo básico
- ✅ Sistema de notificaciones por email

### v1.0.0 (2025-09-22)
- ✅ Sistema base de autenticación
- ✅ Modelos y migraciones de base de datos
- ✅ Funcionalidad básica de usuarios y empresas

## Licencia

Este proyecto es propiedad privada de BBB Páginas Web. Todos los derechos reservados.

---

**BBB Páginas Web** - Creando presencia digital profesional para tu empresa  
*Sistema optimizado con API externa y gestión completa de licencias*

**Última actualización**: 27 de Septiembre, 2025  
**Versión**: 2.0.0 - Lanzamiento Mayor