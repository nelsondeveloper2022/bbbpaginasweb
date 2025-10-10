# Sistema de Pagos con Wompi - BBB Páginas Web

Sistema completo para la gestión de pagos online utilizando la pasarela de pagos Wompi.

## 📋 Componentes Implementados

### 1. Modelos Eloquent

- **BbbEmpresaPago** (`app/Models/BbbEmpresaPago.php`)
  - Gestiona la configuración de pagos online de cada empresa
  - Relación con `BbbEmpresa` y `BbbEmpresaPasarela`
  
- **BbbEmpresaPasarela** (`app/Models/BbbEmpresaPasarela.php`)
  - Almacena las credenciales de Wompi (encriptadas)
  - Maneja configuración de sandbox/producción
  - Métodos helper para obtener URLs de API según ambiente

- **BbbVentaPagoConfirmacion** (`app/Models/BbbVentaPagoConfirmacion.php`)
  - Registra todas las confirmaciones de pago recibidas de Wompi
  - Almacena el payload completo en formato JSON
  - Helpers para formateo y visualización de estados

### 2. Controladores

- **Admin\PagosController** (`app/Http/Controllers/Admin/PagosController.php`)
  - `index()` - Vista principal de configuración
  - `storeWompi()` - Guardar/actualizar configuración de Wompi
  - `toggleWompi()` - Activar/desactivar Wompi vía AJAX
  - `showConfirmacion()` - Ver detalle de una confirmación
  - `filterConfirmaciones()` - Filtrar confirmaciones por estado/fecha

- **WompiController** (`app/Http/Controllers/WompiController.php`)
  - `confirmacionPago()` - Webhook para recibir notificaciones de Wompi
  - `validateSignature()` - Validar firma de integridad
  - `updateVentaStatus()` - Actualizar estado de venta según pago
  - `getTransactionStatus()` - Consultar estado de una transacción

### 3. Vistas Blade

- **admin/pagos/index.blade.php**
  - Formulario de configuración de Wompi
  - Estadísticas de pagos
  - Listado de confirmaciones con filtros
  - Indicadores visuales de estado

- **admin/pagos/confirmacion.blade.php**
  - Detalle completo de la confirmación
  - Información de la venta y cliente
  - Productos incluidos en la venta
  - Payload completo de Wompi en JSON

### 4. Rutas

```php
// Rutas protegidas (Admin)
Route::prefix('admin/pagos')->middleware(['auth', 'check.trial'])->group(function () {
    Route::get('/', [PagosController::class, 'index'])->name('admin.pagos.index');
    Route::post('/wompi/store', [PagosController::class, 'storeWompi'])->name('admin.pagos.wompi.store');
    Route::post('/wompi/toggle', [PagosController::class, 'toggleWompi'])->name('admin.pagos.wompi.toggle');
    Route::get('/confirmacion/{id}', [PagosController::class, 'showConfirmacion'])->name('admin.pagos.confirmacion');
    Route::get('/filter', [PagosController::class, 'filterConfirmaciones'])->name('admin.pagos.filter');
});

// Webhook público (sin autenticación)
Route::post('/wompi/confirmacion-pago', [WompiController::class, 'confirmacionPago'])->name('wompi.webhook');
Route::get('/wompi/transaction/{transactionId}', [WompiController::class, 'getTransactionStatus'])->name('wompi.transaction');
```

## 🚀 Instalación y Configuración

### 1. Ejecutar Migraciones

Las tablas ya deben estar creadas en tu base de datos:
- `bbbempresapagos`
- `bbbempresapasarelas`
- `bbbventapagoconfirmacion`

### 2. Acceder al Panel de Configuración

1. Ingresa al panel de administración
2. Navega a `/admin/pagos`
3. Completa el formulario con tus credenciales de Wompi:
   - **Public Key**: `pub_prod_xxxxxx` o `pub_test_xxxxxx`
   - **Private Key**: `prv_prod_xxxxxx` o `prv_test_xxxxxx`
   - **Events Key** (opcional): `prod_events_xxxxxx`
   - **Integrity Key** (opcional): `prod_integrity_xxxxxx`
   - **Modo Sandbox**: Marcar para pruebas

### 3. Configurar Webhook en Wompi

1. Ingresa a tu cuenta de Wompi (https://comercios.wompi.co/)
2. Ve a **Configuración → Webhooks**
3. Agrega la URL de tu webhook:
   ```
   https://tudominio.com/wompi/confirmacion-pago
   ```
4. Selecciona los eventos:
   - `transaction.updated`
5. Copia el **Events Secret** y agrégalo en la configuración

## 📝 Flujo de Pago

### 1. Cliente realiza un pago

```javascript
// Ejemplo de integración en frontend
const checkout = new WidgetCheckout({
    currency: 'COP',
    amountInCents: 50000 * 100, // $50,000 COP
    reference: 'VENTA-123', // ID de tu venta
    publicKey: 'pub_prod_xxxxxx',
    redirectUrl: 'https://tudominio.com/pago-exitoso'
});

checkout.open(function (result) {
    var transaction = result.transaction;
    console.log('Transaction ID:', transaction.id);
    console.log('Status:', transaction.status);
});
```

### 2. Wompi procesa el pago

- El cliente completa el pago en la interfaz de Wompi
- Wompi actualiza el estado de la transacción
- Wompi envía un webhook a tu endpoint

### 3. Tu sistema recibe la confirmación

```
POST /wompi/confirmacion-pago
Content-Type: application/json
X-Event-Signature: <firma-hmac-sha256>

{
  "event": "transaction.updated",
  "data": {
    "transaction": {
      "id": "12345-67890",
      "status": "APPROVED",
      "reference": "VENTA-123",
      "amount_in_cents": 5000000,
      "currency": "COP",
      ...
    }
  },
  "sent_at": "2025-10-01T12:00:00.000Z"
}
```

### 4. El sistema procesa automáticamente

✅ Valida la firma de integridad  
✅ Busca la venta por referencia  
✅ Crea registro en `bbbventapagoconfirmacion`  
✅ Actualiza el estado de la venta  
✅ Registra en logs  

## 🔐 Seguridad

### Validación de Firma

El sistema valida automáticamente la firma HMAC SHA-256 enviada por Wompi:

```php
$signature = $request->header('X-Event-Signature');
$payload = $request->getContent();
$expectedSignature = hash_hmac('sha256', $payload, $integrityKey);

if (!hash_equals($expectedSignature, $signature)) {
    // Firma inválida - rechazar
}
```

### Encriptación de Llaves

Las llaves privadas se encriptan automáticamente usando el sistema de encriptación de Laravel:

```php
$wompiPasarela->private_key = Crypt::encryptString($request->private_key);
```

## 📊 Estados de Pago

| Estado Wompi | Estado Venta | Descripción |
|-------------|-------------|-------------|
| `APPROVED` | `completada` | Pago aprobado exitosamente |
| `DECLINED` | `cancelada` | Pago rechazado |
| `VOIDED` | `cancelada` | Pago anulado |
| `ERROR` | `cancelada` | Error en el proceso |
| `PENDING` | `pendiente` | Pago pendiente de confirmación |

## 🔍 Consultar Confirmaciones

### Filtros Disponibles

- **Estado**: APPROVED, PENDING, DECLINED, VOIDED, ERROR
- **Rango de fechas**: Desde / Hasta
- **Referencia**: Búsqueda por texto

### Ver Detalle

Desde el listado, haz clic en el icono 👁️ para ver:
- Información completa de la transacción
- Datos del cliente
- Productos incluidos en la venta
- Timeline de eventos
- Payload JSON completo de Wompi

## 🧪 Modo Sandbox (Pruebas)

### Tarjetas de Prueba Wompi

```
VISA Aprobada:
  Número: 4242 4242 4242 4242
  CVV: 123
  Fecha: Cualquier fecha futura

MasterCard Rechazada:
  Número: 5555 5555 5555 4444
  CVV: 123
  Fecha: Cualquier fecha futura
```

### URLs según Ambiente

**Sandbox:**
- API: `https://sandbox.wompi.co/v1`
- Checkout: `https://checkout.wompi.co/l`

**Producción:**
- API: `https://production.wompi.co/v1`
- Checkout: `https://checkout.wompi.co/p`

## 📧 Notificaciones

El sistema está preparado para enviar notificaciones. Actualmente solo registra en logs, pero puedes implementar:

```php
// En WompiController@sendNotifications()

// Enviar email al admin
Mail::to($empresa->email)->send(new VentaPagoConfirmada($venta, $confirmacion));

// Enviar email al cliente
Mail::to($cliente->email)->send(new PagoRecibido($venta, $confirmacion));

// Enviar SMS
// Enviar notificación push
// etc.
```

## 🐛 Troubleshooting

### Webhook no recibe notificaciones

1. ✅ Verifica que la URL sea accesible públicamente
2. ✅ Revisa que no haya middleware que bloquee el POST
3. ✅ Confirma que la URL esté registrada en Wompi
4. ✅ Revisa los logs: `storage/logs/laravel.log`

### Error de firma inválida

1. ✅ Verifica que el Integrity Key sea correcto
2. ✅ Confirma que el payload no se modifique antes de validar
3. ✅ Revisa el header `X-Event-Signature`

### Venta no se encuentra

1. ✅ Verifica que la referencia coincida con el ID de la venta
2. ✅ Revisa el campo `observaciones` si guardas la referencia allí
3. ✅ Confirma que la venta exista en la base de datos

## 📚 Documentación Oficial

- [Documentación de Wompi](https://docs.wompi.co/)
- [Widget de Checkout](https://docs.wompi.co/docs/en/widget-checkout)
- [Webhooks](https://docs.wompi.co/docs/en/eventos-web-checkout-wompi)
- [API Reference](https://docs.wompi.co/docs/en/api-reference)

## 🆘 Soporte

Para reportar problemas o solicitar nuevas funcionalidades, contacta al equipo de desarrollo.

---

**Desarrollado con ❤️ para BBB Páginas Web**  
**Versión 1.0.0** - Octubre 2025
