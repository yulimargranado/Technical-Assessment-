### Etapa II — Procesamiento API

Este documento detalla el proceso realizado en Postman para la etapa de Procesamiento API de la prueba técnica.  

En la Etapa I (tokenización) ya fue completada y documentada en el `README.md`. En esta etapa se usó el token obtenido para ejecutar cargos, anulaciones y consultas de transacciones.

---

#### 🔧 Pre-requisitos
- Credenciales UAT (Public y Private Merchant IDs, Private Credential ID).
- Token de tarjeta generado en la etapa I (almacenado como "{{CARD_TOKEN}}" en Postman).
- Postman con entorno configurado (postman/Kushki.env.json).
- Variables de entorno recomendadas:

**json**
BASE_URL = https://api-uat.kushkipagos.com
PRIVATE_MERCHANT_ID = {{PRIVATE_MERCHANT_ID}}
PRIVATE_CREDENTIAL_ID = {{PRIVATE_CREDENTIAL_ID}}
CARD_TOKEN = {{CARD_TOKEN}}
CURRENCY = CLP
SUBTOTAL = 1000

---
## Pasos realizados
- Se crea el workspace en Postman: postman/Kushki.postman_collection.json
- Se crean las solicitudes:

---

Cargo (Charge)

Endpoint
POST https://api-uat.kushkipagos.com/card/v1/charges

Headers

Content-Type: application/json

Private-Merchant-Id: {{PRIVATE_MERCHANT_ID}}

Body
{
  "token": "fce70e0cd98b4df981863d93c3e7db2a",
  "amount": {
    "subtotalIva": 0,
    "iva": 0,
    "subtotalIva0": 1000,
    "currency": "COP"
  },
  "fullResponse": true
}

cURL
curl --location 'https://api-uat.kushkipagos.com/card/v1/charges' \
--header 'Content-Type: application/json' \
--header 'Private-Merchant-Id: 2baadccc013e448cbb10487f92a18818' \
--data '{
  "token": "fce70e0cd98b4df981863d93c3e7db2a",
  "amount": {
    "subtotalIva": 0,
    "iva": 0,
    "subtotalIva0": 1000,
    "currency": "COP"
  },
  "fullResponse": true
}'

Evidencia: postman/responses/transactions_charge.json

---

Delete (void)

Endpoint
DELETE https://api-uat.kushkipagos.com/v1/charges/283205363154553777/

Headers

Content-Type: application/json

Private-Merchant-Id: {{PRIVATE_MERCHANT_ID}}

Body
{ 
"fullResponse": true 
}

cURL
curl --location --request DELETE 'https://api-uat.kushkipagos.com/v1/charges/283205363154553777' \
--header 'Content-Type: application/json' \
--header 'Private-Merchant-Id: 2baadccc013e448cbb10487f92a18818' \
--data '{ "fullResponse": true }'

Evidencia: postman/responses/transactions_void.json

---

Transactions List (list)

Endpoint
GET https://api-uat.kushkipagos.com/analytics/v2/transactions-list

Headers

Private-Credential-Id: TU_LLAVE_PRIVADA

Content-Type: application/json

Accept: application/json

Body
{
  "page": 1,
  "filters": {
    "transaction_reference": "283205363154553777"
  }
}

cURL
curl --location --request GET 'https://api-uat.kushkipagos.com/analytics/v2/transactions-list' \
--header 'Content-Type: application/json' \
--header 'Accept: application/json' \
--header 'Private-Credential-Id: 2039b24f235745cdb82ee05d89dfb315' \
--data '{
  "page": 1,
  "size": 10,
  "filters": {
    "transaction_reference": "283205363154553777"
  }
}'

Evidencia: postman/responses/transactions_list.json


