# 🚀 Sistema de Pagos con Wompi - Guía de Inicio Rápido

## ✅ Archivos Creados/Modificados

### Modelos (app/Models/)
- ✅ `BbbEmpresaPago.php` - Configuración de pagos de la empresa
- ✅ `BbbEmpresaPasarela.php` - Gestión de pasarelas (actualizado)
- ✅ `BbbVentaPagoConfirmacion.php` - Registro de confirmaciones de pago
- ✅ `BbbVentaOnline.php` - Añadida relación con confirmaciones

### Controladores (app/Http/Controllers/)
- ✅ `Admin/PagosController.php` - Panel de administración de pagos
- ✅ `WompiController.php` - Webhook y procesamiento de notificaciones

### Vistas (resources/views/admin/pagos/)
- ✅ `index.blade.php` - Panel principal con configuración y listado
- ✅ `confirmacion.blade.php` - Detalle de confirmación de pago

### Rutas
- ✅ `routes/web.php` - Rutas añadidas para admin y webhook

### Layout
- ✅ `resources/views/layouts/dashboard.blade.php` - Menú actualizado con enlace a Pagos

### Documentación
- ✅ `WOMPI_INTEGRATION.md` - Documentación completa del sistema
- ✅ `test-wompi-webhook.sh` - Script de prueba del webhook
- ✅ `database/migrations/2025_10_01_000000_create_payment_tables.php` - Referencia de migraciones

## 🎯 Pasos de Configuración

### 1. Verificar que las tablas existan en la base de datos

```sql
-- Verificar tablas
SHOW TABLES LIKE 'bbbempresa%';
SHOW TABLES LIKE 'bbbventa%';

-- Si no existen, puedes usar la migración de referencia:
-- php artisan migrate
```

### 2. Acceder al Panel de Configuración

1. Inicia tu servidor Laravel:
   ```bash
   php artisan serve
   ```

2. Accede a tu panel de administración y navega a:
   ```
   http://localhost:8000/admin/pagos
   ```

3. Verás el formulario de configuración de Wompi

### 3. Configurar Wompi

#### Modo Sandbox (Pruebas)

Obtén tus credenciales de prueba en: https://comercios.wompi.co/

```
Public Key (Test): pub_test_xxxxxxxxxx
Private Key (Test): prv_test_xxxxxxxxxx
Events Key (opcional): test_events_xxxxxxxxxx
Integrity Key (opcional): test_integrity_xxxxxxxxxx
```

Marca el checkbox **"Modo Sandbox (Pruebas)"** ✅

#### Modo Producción

Una vez que todo funcione correctamente en sandbox:

```
Public Key (Prod): pub_prod_xxxxxxxxxx
Private Key (Prod): prv_prod_xxxxxxxxxx
Events Key (opcional): prod_events_xxxxxxxxxx
Integrity Key (opcional): prod_integrity_xxxxxxxxxx
```

Desmarca el checkbox de Sandbox

### 4. Configurar Webhook en Wompi

1. Ve a tu panel de Wompi: https://comercios.wompi.co/
2. Navega a **Configuración → Webhooks**
3. Agrega tu URL:
   - **Desarrollo/Local**: `http://tu-ngrok-url.ngrok.io/wompi/confirmacion-pago`
   - **Producción**: `https://tudominio.com/wompi/confirmacion-pago`
4. Selecciona el evento: `transaction.updated`
5. Guarda y copia el **Events Secret** (para validación de firma)

### 5. Probar el Webhook Localmente

#### Opción A: Usando el script de prueba

```bash
cd /Users/nelsonmoncada/Documents/nelson_proyects/bbb
./test-wompi-webhook.sh
```

Este script simula una notificación de Wompi a tu endpoint local.

#### Opción B: Usando cURL manualmente

```bash
curl -X POST http://localhost:8000/wompi/confirmacion-pago \
  -H "Content-Type: application/json" \
  -d '{
    "event": "transaction.updated",
    "data": {
      "transaction": {
        "id": "TEST-12345",
        "reference": "1",
        "status": "APPROVED",
        "amount_in_cents": 5000000,
        "currency": "COP",
        "customer_email": "test@example.com"
      }
    }
  }'
```

#### Opción C: Usar ngrok para pruebas con Wompi real

```bash
# Instalar ngrok si no lo tienes
brew install ngrok

# Exponer tu servidor local
ngrok http 8000

# Copiar la URL generada (ej: https://abc123.ngrok.io)
# Configurarla en Wompi como: https://abc123.ngrok.io/wompi/confirmacion-pago
```

### 6. Verificar que todo funciona

1. **Ver Logs**:
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Revisar el Panel**:
   - Ve a `/admin/pagos`
   - Deberías ver la confirmación de pago en el listado
   - Haz clic en el ícono 👁️ para ver el detalle completo

3. **Verificar la Base de Datos**:
   ```sql
   SELECT * FROM bbbventapagoconfirmacion ORDER BY created_at DESC LIMIT 10;
   ```

## 🔧 Integración en tu Frontend

### Ejemplo básico con Widget de Wompi

```html
<!DOCTYPE html>
<html>
<head>
    <script src="https://checkout.wompi.co/widget.js"></script>
</head>
<body>
    <button id="pay-button">Pagar Ahora</button>

    <script>
        document.getElementById('pay-button').addEventListener('click', function() {
            var checkout = new WidgetCheckout({
                currency: 'COP',
                amountInCents: 5000000, // $50,000 COP
                reference: '123', // ID de tu venta
                publicKey: 'pub_prod_xxxxxxxxxx', // Tu public key
                redirectUrl: 'https://tudominio.com/pago-exitoso',
                customerData: {
                    email: 'cliente@example.com',
                    fullName: 'Juan Pérez',
                    phoneNumber: '3001234567',
                    legalId: '1234567890',
                    legalIdType: 'CC'
                }
            });

            checkout.open(function(result) {
                var transaction = result.transaction;
                console.log('Transaction:', transaction);
                // El webhook se encargará del resto
            });
        });
    </script>
</body>
</html>
```

### Ejemplo con Laravel Blade

```blade
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h3>Resumen de tu pedido</h3>
            <p><strong>Total:</strong> ${{ number_format($venta->total, 0, ',', '.') }}</p>
            
            <button id="pay-button" class="btn btn-primary">
                Pagar con Wompi
            </button>
        </div>
    </div>
</div>

<script src="https://checkout.wompi.co/widget.js"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function() {
        var checkout = new WidgetCheckout({
            currency: 'COP',
            amountInCents: {{ $venta->total * 100 }},
            reference: '{{ $venta->idVenta }}',
            publicKey: '{{ $wompiPublicKey }}',
            redirectUrl: '{{ route("pago.exitoso", $venta->idVenta) }}',
            customerData: {
                email: '{{ $cliente->email }}',
                fullName: '{{ $cliente->nombre }}',
                phoneNumber: '{{ $cliente->telefono }}',
                legalId: '{{ $cliente->documento }}',
                legalIdType: 'CC'
            }
        });

        checkout.open(function(result) {
            if (result.transaction.status === 'APPROVED') {
                window.location.href = '{{ route("pago.exitoso", $venta->idVenta) }}';
            }
        });
    });
</script>
@endsection
```

## 📊 Flujo Completo

```
┌─────────────┐
│  Cliente    │
│  en tu web  │
└──────┬──────┘
       │ 1. Hace clic en "Pagar"
       ↓
┌─────────────┐
│   Widget    │
│   Wompi     │
└──────┬──────┘
       │ 2. Procesa el pago
       ↓
┌─────────────┐
│   Wompi     │
│   Backend   │
└──────┬──────┘
       │ 3. Envía webhook
       ↓
┌─────────────────────────┐
│  Tu Sistema             │
│  /wompi/confirmacion    │
│  - Valida firma         │
│  - Busca la venta       │
│  - Guarda confirmación  │
│  - Actualiza estado     │
└─────────────────────────┘
```

## 🎨 Personalización

### Cambiar los colores del formulario

Edita `/resources/views/admin/pagos/index.blade.php`:

```css
.bg-gradient-primary {
    background: linear-gradient(135deg, #TU_COLOR 0%, #TU_COLOR_2 100%);
}
```

### Agregar campos adicionales

En `/app/Models/BbbVentaPagoConfirmacion.php`, añade campos al array `$fillable`.

### Modificar notificaciones

En `/app/Http/Controllers/WompiController.php`, edita el método `sendNotifications()`.

## 🐛 Troubleshooting

### ❌ Webhook no recibe notificaciones

**Solución**:
1. Verifica que la URL sea accesible públicamente (usa ngrok en desarrollo)
2. Revisa que no haya middleware de autenticación bloqueando
3. Confirma que la URL esté registrada correctamente en Wompi
4. Revisa los logs: `tail -f storage/logs/laravel.log`

### ❌ Error "Venta no encontrada"

**Solución**:
1. Verifica que la `reference` en Wompi coincida con el `idVenta`
2. Confirma que la venta exista en la base de datos
3. Revisa el campo `referencia` en la tabla `bbbventaonline`

### ❌ Error de firma inválida

**Solución**:
1. Verifica que el `Integrity Key` sea correcto
2. No modifiques el payload antes de validar la firma
3. Confirma que el header `X-Event-Signature` esté presente

### ❌ No se actualiza el estado de la venta

**Solución**:
1. Verifica que la relación entre `BbbVentaOnline` y `BbbVentaPagoConfirmacion` esté correcta
2. Revisa el método `updateVentaStatus()` en `WompiController.php`
3. Confirma que el estado de Wompi sea válido (APPROVED, DECLINED, etc.)

## 📞 Recursos Adicionales

- 📖 [Documentación completa](WOMPI_INTEGRATION.md)
- 🌐 [Docs oficiales de Wompi](https://docs.wompi.co/)
- 💬 [Soporte de Wompi](https://docs.wompi.co/docs/en/support)

## ✨ Funcionalidades Implementadas

✅ Configuración completa de Wompi desde el admin  
✅ Encriptación automática de llaves privadas  
✅ Validación de firma de integridad  
✅ Registro completo de confirmaciones de pago  
✅ Actualización automática del estado de ventas  
✅ Filtros avanzados de búsqueda  
✅ Vista detallada de cada transacción  
✅ Soporte para Sandbox y Producción  
✅ Logs detallados para debugging  
✅ UI moderna y responsive  

## 🎉 ¡Listo!

Tu sistema de pagos con Wompi está completamente configurado y listo para usar.

**Próximos pasos sugeridos:**
1. Probar en modo Sandbox
2. Realizar transacciones de prueba
3. Verificar que las confirmaciones se guarden correctamente
4. Implementar notificaciones por email (opcional)
5. Pasar a producción cuando todo funcione

---

**Desarrollado con ❤️ para BBB Páginas Web**  
Si tienes preguntas, revisa los logs o contacta al equipo de desarrollo.
