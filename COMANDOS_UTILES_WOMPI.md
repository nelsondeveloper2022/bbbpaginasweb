# Comandos Útiles - Sistema de Pagos Wompi

## 🚀 Desarrollo

### Iniciar el servidor
```bash
php artisan serve
```

### Ver logs en tiempo real
```bash
tail -f storage/logs/laravel.log
```

### Limpiar caché
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## 🗄️ Base de Datos

### Verificar tablas
```bash
php artisan tinker
```
```php
DB::select('SHOW TABLES LIKE "bbbempresa%"');
DB::select('SHOW TABLES LIKE "bbbventa%"');
```

### Ver configuración de pagos
```bash
php artisan tinker
```
```php
use App\Models\BbbEmpresaPago;
use App\Models\BbbEmpresaPasarela;

// Ver todas las configuraciones
BbbEmpresaPago::with('pasarelas')->get();

// Ver configuración de Wompi de una empresa
$pagoConfig = BbbEmpresaPago::where('idEmpresa', 1)->first();
$wompi = $pagoConfig->wompiPasarela;
echo "Wompi activo: " . ($wompi->activo ? 'Sí' : 'No');
echo "Sandbox: " . ($wompi->isSandbox() ? 'Sí' : 'No');
```

### Ver confirmaciones de pago
```bash
php artisan tinker
```
```php
use App\Models\BbbVentaPagoConfirmacion;

// Ver últimas 5 confirmaciones
BbbVentaPagoConfirmacion::latest('fecha_confirmacion')
    ->with('venta')
    ->take(5)
    ->get()
    ->each(function($c) {
        echo "\nID: {$c->idPagoConfirmacion}\n";
        echo "Estado: {$c->getStatusText()}\n";
        echo "Monto: {$c->getFormattedAmount()}\n";
        echo "Fecha: {$c->fecha_confirmacion}\n";
        echo "---\n";
    });

// Contar por estado
BbbVentaPagoConfirmacion::selectRaw('estado, COUNT(*) as total')
    ->groupBy('estado')
    ->get();
```

### Crear una venta de prueba
```bash
php artisan tinker
```
```php
use App\Models\BbbVentaOnline;
use App\Models\BbbCliente;

// Crear o usar un cliente existente
$cliente = BbbCliente::first();

// Crear venta de prueba
$venta = BbbVentaOnline::create([
    'idEmpresa' => 1,
    'idCliente' => $cliente->idCliente,
    'fecha' => now(),
    'total' => 50000,
    'estado' => 'pendiente',
    'metodo_pago' => 'wompi',
    'observaciones' => 'Venta de prueba'
]);

echo "Venta creada con ID: {$venta->idVenta}";
```

## 🧪 Pruebas

### Probar webhook localmente
```bash
./test-wompi-webhook.sh
```

### Probar con cURL (transacción aprobada)
```bash
curl -X POST http://localhost:8000/wompi/confirmacion-pago \
  -H "Content-Type: application/json" \
  -d '{
    "event": "transaction.updated",
    "data": {
      "transaction": {
        "id": "TEST-APPROVED-001",
        "reference": "1",
        "status": "APPROVED",
        "amount_in_cents": 5000000,
        "currency": "COP",
        "customer_email": "test@example.com",
        "payment_method_type": "CARD"
      }
    }
  }'
```

### Probar con cURL (transacción rechazada)
```bash
curl -X POST http://localhost:8000/wompi/confirmacion-pago \
  -H "Content-Type: application/json" \
  -d '{
    "event": "transaction.updated",
    "data": {
      "transaction": {
        "id": "TEST-DECLINED-001",
        "reference": "1",
        "status": "DECLINED",
        "amount_in_cents": 5000000,
        "currency": "COP",
        "customer_email": "test@example.com",
        "payment_method_type": "CARD"
      }
    }
  }'
```

### Probar con Postman

**URL**: `POST http://localhost:8000/wompi/confirmacion-pago`

**Headers**:
```
Content-Type: application/json
```

**Body** (raw JSON):
```json
{
  "event": "transaction.updated",
  "data": {
    "transaction": {
      "id": "12345-67890",
      "reference": "1",
      "status": "APPROVED",
      "amount_in_cents": 5000000,
      "currency": "COP",
      "customer_email": "cliente@example.com",
      "payment_method_type": "CARD",
      "created_at": "2025-10-01T12:00:00.000Z",
      "finalized_at": "2025-10-01T12:00:05.000Z"
    }
  },
  "sent_at": "2025-10-01T12:00:10.000Z"
}
```

## 🌐 Exposer con ngrok (para pruebas con Wompi real)

### Instalar ngrok
```bash
brew install ngrok
# o descarga desde https://ngrok.com/download
```

### Exponer servidor local
```bash
ngrok http 8000
```

Copia la URL generada (ej: `https://abc123.ngrok.io`) y úsala en Wompi:
```
https://abc123.ngrok.io/wompi/confirmacion-pago
```

## 📊 Consultas SQL Útiles

### Ver última confirmación de cada venta
```sql
SELECT 
    v.idVenta,
    v.total,
    v.estado as estado_venta,
    c.referencia,
    c.transaccion_id,
    c.estado as estado_pago,
    c.monto,
    c.fecha_confirmacion
FROM bbbventaonline v
LEFT JOIN bbbventapagoconfirmacion c ON v.idVenta = c.idVenta
WHERE v.idEmpresa = 1
ORDER BY c.fecha_confirmacion DESC;
```

### Estadísticas de pagos
```sql
SELECT 
    estado,
    COUNT(*) as cantidad,
    SUM(monto) as total_monto,
    AVG(monto) as promedio
FROM bbbventapagoconfirmacion
WHERE idEmpresa = 1
GROUP BY estado;
```

### Pagos por día
```sql
SELECT 
    DATE(fecha_confirmacion) as fecha,
    COUNT(*) as cantidad,
    SUM(monto) as total
FROM bbbventapagoconfirmacion
WHERE idEmpresa = 1
  AND fecha_confirmacion >= DATE_SUB(NOW(), INTERVAL 30 DAY)
GROUP BY DATE(fecha_confirmacion)
ORDER BY fecha DESC;
```

### Transacciones fallidas
```sql
SELECT 
    transaccion_id,
    referencia,
    estado,
    monto,
    respuesta_completa->'$.data.transaction.status_message' as mensaje_error,
    fecha_confirmacion
FROM bbbventapagoconfirmacion
WHERE estado IN ('DECLINED', 'ERROR', 'VOIDED')
  AND idEmpresa = 1
ORDER BY fecha_confirmacion DESC
LIMIT 20;
```

## 🔧 Mantenimiento

### Backup de confirmaciones
```bash
php artisan tinker
```
```php
use App\Models\BbbVentaPagoConfirmacion;
use Illuminate\Support\Facades\Storage;

$confirmaciones = BbbVentaPagoConfirmacion::all();
$json = $confirmaciones->toJson(JSON_PRETTY_PRINT);
Storage::put('backups/confirmaciones_' . date('Y-m-d') . '.json', $json);
echo "Backup guardado en storage/app/backups/";
```

### Limpiar logs antiguos
```bash
# Mantener solo los últimos 7 días
find storage/logs -name "*.log" -mtime +7 -delete
```

### Optimizar base de datos
```bash
php artisan optimize
php artisan db:seed --class=DatabaseOptimizer  # Si existe
```

## 🐛 Debug

### Ver todas las rutas relacionadas con pagos
```bash
php artisan route:list | grep -i pago
php artisan route:list | grep -i wompi
```

### Verificar configuración
```bash
php artisan tinker
```
```php
// Verificar config de Wompi
config('wompi.public_key');
config('wompi.environment');

// Ver rutas registradas
app('router')->getRoutes()->match(
    app('request')->create('/wompi/confirmacion-pago', 'POST')
)->getName();
```

### Test de conectividad con Wompi
```bash
curl https://production.wompi.co/v1/merchants/pub_prod_xxxxxxxxxx
```

## 📝 Notas

- Siempre prueba en **modo Sandbox** antes de producción
- Mantén tus llaves privadas **seguras** y **encriptadas**
- Revisa los logs regularmente
- Haz backups periódicos de las confirmaciones
- Monitorea las transacciones fallidas

## 🆘 Soporte

Si encuentras problemas:
1. Revisa `storage/logs/laravel.log`
2. Verifica la configuración en `/admin/pagos`
3. Prueba el webhook con el script de prueba
4. Consulta la documentación de Wompi: https://docs.wompi.co/

---

**Última actualización**: Octubre 2025
