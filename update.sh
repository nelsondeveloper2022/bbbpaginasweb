#!/bin/bash

# Colores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Configuración del servidor (mantener en sync con deploy.sh)
SERVER_USER="u675855880"
SERVER_HOST="46.202.183.32"
SERVER_PORT="65002"
SERVER_PATH="/home/u675855880/domains/bbbpaginasweb.com/back"

# Directorios (estructura correcta incluye 'views')
REMOTE_DIR="${SERVER_PATH}/resources/views/landings/"
LOCAL_DIR="resources/views/landings/"

echo -e "${GREEN}⬇️  Iniciando actualización desde servidor: resources/landings${NC}\n"

# Flags de rsync
RSYNC_FLAGS="-avz --delete --progress"
if [ "${DRY_RUN}" = "1" ]; then
    RSYNC_FLAGS="${RSYNC_FLAGS} --dry-run --itemize-changes"
    echo -e "${YELLOW}🧪 Modo DRY RUN activado: no se aplicarán cambios locales${NC}"
fi

# Crear carpeta local si no existe
mkdir -p "${LOCAL_DIR}"

# Sincronizar desde REMOTO -> LOCAL (pull)
# Nota: usamos la barra final en REMOTE_DIR para copiar SOLO el contenido dentro de landings
sshpass -p '!5Vt3Vm.4a7DQ5R' rsync ${RSYNC_FLAGS} \
    -e "ssh -p ${SERVER_PORT}" \
    --exclude='.DS_Store' \
    --exclude='node_modules' \
    --exclude='.git' \
    "${SERVER_USER}@${SERVER_HOST}:${REMOTE_DIR}" \
    "${LOCAL_DIR}"

RSYNC_STATUS=$?

if [ ${RSYNC_STATUS} -ne 0 ]; then
    echo -e "${RED}❌ Error al actualizar resources/landings desde el servidor${NC}"
    exit ${RSYNC_STATUS}
fi

echo -e "${GREEN}✅ Carpeta resources/landings actualizada correctamente desde el servidor${NC}"
