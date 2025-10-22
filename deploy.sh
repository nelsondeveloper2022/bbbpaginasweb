#!/bin/bash

# Colores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Configuración del servidor
SERVER_USER="u675855880"
SERVER_HOST="46.202.183.32"
SERVER_PORT="65002"
SERVER_PATH="/home/u675855880/domains/bbbpaginasweb.com/back"

echo -e "${GREEN}🚀 Iniciando proceso de deploy...${NC}\n"

# Paso 1: Compilar assets con Vite
echo -e "${YELLOW}📦 Compilando assets con Vite...${NC}"
npm run build
if [ $? -ne 0 ]; then
    echo -e "${RED}❌ Error al compilar assets${NC}"
    exit 1
fi
echo -e "${GREEN}✅ Assets compilados correctamente${NC}\n"

# Paso 2: Subir archivos al servidor usando rsync (solo lo solicitado)
echo -e "${YELLOW}📤 Subiendo archivos al servidor (solo app, resources, config, vendor, node, node_modules y archivos de configuración)...${NC}"
echo -e "${YELLOW}➡️  Nota: Incluyendo la carpeta 'routes' para desplegar cambios de rutas${NC}"

# Permite ejecutar un despliegue de prueba sin aplicar cambios con DRY_RUN=1
RSYNC_FLAGS="-avz --delete --progress"
if [ "${DRY_RUN}" = "1" ]; then
        RSYNC_FLAGS="${RSYNC_FLAGS} --dry-run --itemize-changes"
        echo -e "${YELLOW}🧪 Modo DRY RUN activado: no se aplicarán cambios reales${NC}"
fi

# Construir lista de rutas a sincronizar, solo las solicitadas
SYNC_PATHS=(
    "app"
    "bootstrap"
    "routes"
    "resources"
    "config"
    "vendor"
    "node_modules"
    "composer.json"
    "composer.lock"
    "package.json"
    "package-lock.json"
)

# Incluir carpeta 'node' si existe y/o 'node_modules' si existiera
if [ -d "node" ]; then
    SYNC_PATHS+=("node")
fi
 # 'node_modules' ya se añadió explícitamente arriba; se filtrará más abajo si no existe.

# Filtrar solo rutas existentes para evitar errores si alguna falta
EXISTING_PATHS=()
for p in "${SYNC_PATHS[@]}"; do
    if [ -e "$p" ]; then
        EXISTING_PATHS+=("$p")
    else
        echo -e "${YELLOW}⚠️  Omitiendo '$p' (no existe)${NC}"
    fi
done

# Nota: No se sincroniza 'public/build' aquí. Asegúrate de gestionar los assets en el servidor si es necesario.

sshpass -p '!5Vt3Vm.4a7DQ5R' rsync ${RSYNC_FLAGS} \
        -e "ssh -p ${SERVER_PORT}" \
        --exclude='.git' \
        --exclude='.env' \
        --exclude='.DS_Store' \
    "${EXISTING_PATHS[@]}" \
        "${SERVER_USER}@${SERVER_HOST}:${SERVER_PATH}/"

if [ $? -ne 0 ]; then
    echo -e "${RED}❌ Error al subir archivos${NC}"
    exit 1
fi
echo -e "${GREEN}✅ Archivos subidos correctamente${NC}\n"

# Paso 3: Ejecutar comandos en el servidor
echo -e "${YELLOW}⚙️  Ejecutando comandos en el servidor...${NC}"
sshpass -p '!5Vt3Vm.4a7DQ5R' ssh -p ${SERVER_PORT} ${SERVER_USER}@${SERVER_HOST} << 'ENDSSH'
cd /home/u675855880/domains/bbbpaginasweb.com/back

echo "🔧 Ajustando permisos..."
# Permisos para directorios de storage y bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache
find storage -type f -exec chmod 664 {} \;
find storage -type d -exec chmod 775 {} \;

echo "🧹 Limpiando cachés de Laravel..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo "� Optimizando autoloader de Composer..."
composer dump-autoload --optimize

echo "�📝 Regenerando cachés optimizados..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Comandos ejecutados correctamente"
ENDSSH

if [ $? -ne 0 ]; then
    echo -e "${RED}❌ Error al ejecutar comandos en el servidor${NC}"
    exit 1
fi

echo -e "\n${GREEN}✨ Deploy completado exitosamente! ✨${NC}"
echo -e "${GREEN}🌐 Tu aplicación está lista en: https://bbbpaginasweb.com${NC}"
