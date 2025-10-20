# Guía de Importación Masiva de Productos

## Descripción General
La funcionalidad de importación masiva permite cargar múltiples productos de forma rápida y eficiente mediante archivos Excel y ZIP con imágenes.

## Proceso de Importación

### 📋 PASO 1: Preparar y Cargar Excel

#### Estructura del Archivo Excel
El archivo Excel debe tener las siguientes columnas en orden:

| Columna | Campo | Tipo | Obligatorio | Descripción |
|---------|-------|------|-------------|-------------|
| **A** | Nombre | Texto | ✅ Sí | Nombre del producto |
| **B** | Referencia | Texto | ✅ Sí | Código único del producto (se usa para crear/actualizar) |
| **C** | Descripción | Texto | ❌ No | Descripción detallada del producto |
| **D** | Precio | Número | ✅ Sí | Precio de venta (puede incluir formato: $30,000 o 30000) |
| **E** | Costo | Número | ❌ No | Costo del producto (puede incluir formato: $17,500 o 17500) |
| **F** | Stock | Número | ✅ Sí | Cantidad disponible en inventario |
| **G** | Nombre Imagen | Texto | ❌ No | Nombre exacto del archivo de imagen (ej: achiote pepa.jpg) |
| **H** | Estado | Texto | ✅ Sí | Estado del producto: `activo` o `inactivo` |

#### Ejemplo de Datos

```
Achiote Pepa Kilo | 001 | Color Intenso Y Sabor Suave... | $30,000 | $17,500 | 0 | achiote pepa.jpg | activo
Achiote Polvo kilo | 002 | Semilla De Color Intenso... | $31,000 | $- | 0 | achiote molido.jpg | activo
Ajo Escama kilo | 003 | Condimento De Aroma Intenso... | $- | | 0 | ajo escama.jpg | activo
```

#### Proceso
1. El sistema valida la estructura del archivo
2. Por cada fila:
   - Si la **referencia** ya existe → **actualiza** el producto
   - Si la **referencia** no existe → **crea** un nuevo producto
3. Los errores se reportan al final sin detener el proceso

### 🖼️ PASO 2: Preparar y Cargar Imágenes (Opcional)

#### Preparación del ZIP
1. Crear una carpeta con todas las imágenes
2. Las imágenes deben tener el mismo nombre especificado en la columna G del Excel
3. Comprimir la carpeta en formato ZIP

#### Ejemplos de Nombres Válidos
- `achiote pepa.jpg` → Busca producto con nombre similar a "achiote pepa"
- `001.png` → Busca producto con referencia "001"
- `producto ejemplo.jpeg` → Busca por coincidencia en nombre

#### Proceso
1. El sistema extrae el ZIP
2. **IMPORTANTE**: Solo procesa productos que tengan el campo `nombre_imagen_original` guardado (productos importados o editados con nombre de imagen)
3. Por cada producto con imagen definida:
   - Normaliza el nombre de imagen esperado (ej: "Achiote Pepa.jpg" → "achiote-pepa.jpg")
   - Busca el archivo en el ZIP con el nombre normalizado
   - Si no encuentra coincidencia exacta, busca por similitud con el slug del producto
   - Valida que sea un archivo de imagen válido
   - Si encuentra la imagen:
     - Elimina la imagen anterior del producto (si existe)
     - Guarda la nueva imagen con un UUID único
     - Actualiza el producto con la URL de la imagen
4. Reporta las imágenes procesadas, asignadas y errores

## Notas Importantes

### ✅ Validaciones
- **Referencia**: Única por empresa, se usa para evitar duplicados
- **Precio**: Puede ser 0 o mayor (no puede ser negativo)
- **Estado**: Solo acepta "activo" o "inactivo" (case-insensitive)
- **Formato de números**: Se limpian automáticamente ($, comas, etc.)
- **Nombres de imagen**: Se normalizan automáticamente (espacios → guiones, minúsculas)

### ⚠️ Consideraciones
- El archivo Excel puede tener o no fila de encabezados
- Si un producto tiene imagen y cargas una nueva, la anterior se reemplaza
- Las imágenes pueden estar en subcarpetas dentro del ZIP
- **Los nombres de archivo se normalizan automáticamente**: "Achiote Pepa.jpg" se busca como "achiote-pepa.jpg"
- La búsqueda de imágenes es case-insensitive (no importa mayúsculas/minúsculas)
- Se ignoran carpetas del sistema como `__MACOSX`
- **Si ya tienes productos en la BD**, puedes cargar imágenes directamente sin procesar Excel primero
- Las imágenes solo se asignan a productos que tienen `nombre_imagen_original` definido

### 🎯 Mejores Prácticas
1. Mantén referencias únicas y consistentes
2. Usa nombres de archivo descriptivos para las imágenes
3. **Los nombres de imagen se normalizan**: "Producto 1.jpg" → "producto-1.jpg"
4. Puedes usar espacios y mayúsculas en los nombres - el sistema los ajusta automáticamente
5. Verifica que los nombres de imágenes en el Excel coincidan con los archivos del ZIP
6. Revisa los errores reportados después de cada importación
7. Haz backup de tus productos antes de importaciones masivas
8. Si ya tienes productos, puedes agregar la columna G al Excel y reimportar para asignar nombres de imagen

## Normalización de Nombres

### ¿Qué es la normalización?
El sistema convierte automáticamente los nombres de productos e imágenes a un formato estándar para garantizar la sincronización correcta.

### Ejemplos de Normalización

| Nombre Original | Nombre Normalizado | Uso |
|----------------|-------------------|-----|
| Achiote Pepa Kilo | achiote-pepa-kilo | Slug del producto |
| Achiote Pepa.jpg | achiote-pepa.jpg | Búsqueda de imagen |
| PRODUCTO 123.PNG | producto-123.png | Búsqueda de imagen |
| Ají_Picante 500g.jpeg | aji-picante-500g.jpeg | Búsqueda de imagen |

### Ventajas
- ✅ No importa si usas mayúsculas o minúsculas
- ✅ Los espacios se convierten automáticamente en guiones
- ✅ Los caracteres especiales (tildes, ñ, etc.) se transforman correctamente
- ✅ Mayor precisión en la sincronización de imágenes con productos

### Recomendación
Puedes escribir los nombres de forma natural en el Excel (con espacios, mayúsculas, tildes). El sistema se encarga de la normalización.

## Formatos Soportados

### Excel
- `.xlsx` (Excel 2007+)
- `.xls` (Excel 97-2003)
- Tamaño máximo: 10 MB

### Imágenes (ZIP)
- `.zip`
- Tamaño máximo: 50 MB
- Formatos de imagen: JPG, PNG, GIF, WEBP, etc.

## Ejemplo Completo

### 1. Archivo Excel: `productos.xlsx`
```
Nombre              | Ref | Descripción      | Precio  | Costo   | Stock | Imagen           | Estado
Achiote Pepa Kilo   | 001 | Color intenso... | 30000   | 17500   | 10    | achiote_pepa.jpg | activo
Pimienta Negra      | 002 | Sabor fuerte...  | 25000   | 12000   | 5     | pimienta.jpg     | activo
```

### 2. Archivo ZIP: `imagenes.zip`
```
imagenes/
  ├── achiote_pepa.jpg
  └── pimienta.jpg
```

### 3. Resultado
- ✅ 2 productos creados
- ✅ 2 imágenes asignadas
- 🔄 Productos disponibles en el sistema

## Errores Comunes

| Error | Causa | Solución |
|-------|-------|----------|
| "La referencia es obligatoria" | Columna B vacía | Asignar referencia única |
| "El precio debe ser mayor a 0" | Precio inválido o vacío | Verificar columna D |
| "No se encontró un producto que coincida" | Nombre de imagen no coincide | Revisar nombres en columna G |
| "El archivo no es una imagen válida" | Archivo corrupto o tipo incorrecto | Usar JPG, PNG, etc. |

## Soporte
Para dudas o problemas, contacta al administrador del sistema.
