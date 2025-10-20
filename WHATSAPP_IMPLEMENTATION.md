# WhatsApp Integration - BBB Páginas Web

## Funcionalidad Implementada

✅ Botón de WhatsApp en la tabla de usuarios del panel administrativo
✅ Modal para seleccionar y personalizar plantillas de WhatsApp
✅ Vista previa de plantillas con variables dinámicas
✅ Envío de mensajes usando WhatsApp Business API
✅ Configuración centralizada en archivo config/whatsapp.php

## Archivos Creados/Modificados

### Nuevos Archivos:
- `app/Http/Controllers/WhatsAppController.php`
- `config/whatsapp.php`

### Archivos Modificados:
- `routes/web.php` - Rutas de WhatsApp
- `resources/views/admin/users.blade.php` - Botón y modal
- `resources/views/admin/layout.blade.php` - jQuery y estilos CSS

## Uso

1. En el panel de administración, ir a "Gestión de Usuarios"
2. Hacer clic en el botón verde de WhatsApp (🟢) junto a cualquier usuario
3. Ingresar el número de teléfono del cliente
4. Seleccionar una plantilla aprobada de WhatsApp
5. Completar las variables de la plantilla
6. Enviar el mensaje

## Configuración

Las credenciales de WhatsApp están configuradas en `config/whatsapp.php`:
- Phone Number ID: 829957880204214
- Business Account ID: 1489092885549950
- Access Token: EAAJN0jczJVY... (completo)
- App ID: 648515217990998

## Rutas Disponibles

- `GET /admin/whatsapp/templates` - Obtener plantillas
- `GET /admin/whatsapp/template/{name}` - Detalles de plantilla
- `POST /admin/whatsapp/send-template` - Enviar mensaje
- `GET /admin/whatsapp/modal/{userId}` - Modal para usuario

La implementación está completa y lista para usar.