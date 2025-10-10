#!/bin/bash

# Script de prueba para el webhook de Wompi
# Simula una notificación de Wompi a tu endpoint local

# Colores para output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}   Test Webhook Wompi - BBB Páginas${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""

# URL del webhook (ajusta según tu entorno)
WEBHOOK_URL="http://localhost:8000/wompi/confirmacion-pago"

# Puedes cambiar estos valores según tus necesidades
TRANSACTION_ID="12345-67890-TEST"
REFERENCE="123"  # ID de la venta en tu sistema
STATUS="APPROVED"  # APPROVED, DECLINED, PENDING, VOIDED, ERROR
AMOUNT_IN_CENTS=5000000  # $50,000 COP = 5,000,000 centavos
CUSTOMER_EMAIL="cliente@example.com"

echo -e "${GREEN}Configuración:${NC}"
echo "URL: $WEBHOOK_URL"
echo "Transaction ID: $TRANSACTION_ID"
echo "Reference: $REFERENCE"
echo "Status: $STATUS"
echo "Amount: $AMOUNT_IN_CENTS centavos"
echo ""

# Payload JSON (estructura real de Wompi)
PAYLOAD=$(cat <<EOF
{
  "event": "transaction.updated",
  "data": {
    "transaction": {
      "id": "$TRANSACTION_ID",
      "created_at": "$(date -u +"%Y-%m-%dT%H:%M:%S.000Z")",
      "finalized_at": "$(date -u +"%Y-%m-%dT%H:%M:%S.000Z")",
      "amount_in_cents": $AMOUNT_IN_CENTS,
      "reference": "$REFERENCE",
      "customer_email": "$CUSTOMER_EMAIL",
      "currency": "COP",
      "payment_method_type": "CARD",
      "payment_method": {
        "type": "CARD",
        "extra": {
          "bin": "424242",
          "name": "VISA-4242",
          "brand": "VISA",
          "exp_year": "28",
          "exp_month": "12",
          "last_four": "4242",
          "card_holder": "Test User",
          "is_three_ds": false
        },
        "installments": 1
      },
      "status": "$STATUS",
      "status_message": null,
      "billing_data": null,
      "shipping_address": null,
      "redirect_url": null,
      "payment_source_id": null,
      "payment_link_id": null,
      "customer_data": {
        "phone_number": "+573001234567",
        "full_name": "Test User",
        "legal_id": "1234567890",
        "legal_id_type": "CC"
      },
      "bill_id": null,
      "taxes": []
    }
  },
  "sent_at": "$(date -u +"%Y-%m-%dT%H:%M:%S.000Z")",
  "timestamp": $(date +%s)
}
EOF
)

echo -e "${GREEN}Enviando petición...${NC}"
echo ""

# Enviar la petición
RESPONSE=$(curl -s -w "\n%{http_code}" -X POST "$WEBHOOK_URL" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d "$PAYLOAD")

# Separar response body y status code
HTTP_BODY=$(echo "$RESPONSE" | sed '$d')
HTTP_STATUS=$(echo "$RESPONSE" | tail -n1)

echo -e "${BLUE}Respuesta del servidor:${NC}"
echo "HTTP Status: $HTTP_STATUS"
echo ""
echo "Body:"
echo "$HTTP_BODY" | jq '.' 2>/dev/null || echo "$HTTP_BODY"
echo ""

# Verificar el resultado
if [ "$HTTP_STATUS" = "200" ]; then
    echo -e "${GREEN}✓ Webhook procesado exitosamente${NC}"
else
    echo -e "${RED}✗ Error al procesar el webhook${NC}"
fi

echo ""
echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}Revisa los logs en storage/logs/laravel.log${NC}"
echo -e "${BLUE}========================================${NC}"
