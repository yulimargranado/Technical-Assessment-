# Technical-Assessment-
prueba para verificar las habilidades técnicas necesarias para el cargo de Technical Support Engineer para Kushki.

I. Kajita de pagos.
---
## Resumen
Se creó una cuenta en el ambiente UAT de Kushki, se configuró una Kajita de Pago Único, se implementó un "index.html" de prueba con el snippet de integración y se validó la generación de token de intención usando tarjetas de prueba en sandbox.

---

## Prerrequisitos
- Acceso al ambiente UAT (correo registrado).
- Rol Usuario Maestro en la consola UAT (requerido para crear Kajitas).
- Herramientas locales para pruebas:
  - Editor de texto.
  - Hosting público https://yulimargranado.github.io/Technical-Assessment-/
  - Servidor publico Webhook.site https://webhook.site/38c446ec-66ed-4fcc-95dc-57bc566496d7
  - Navegador Chrome.
  - Datos de pruebas (documentacion oficial del Kushki)

---

## Pasos realizados

### 1. Crear cuenta en UAT
- Registro realizado en el portal UAT con datos básicos del comercio.
- Correo validado para habilitar acceso.
- Cambio de contraseña requerido. 

<img width="1130" height="805" alt="image" src="https://github.com/user-attachments/assets/0b92bee0-8d61-43a2-b696-c2383ec11a19" />


---

### 2. Validar roles/permisos
- Se confirmó que el usuario tiene rol Usuario Maestro.  
- Este rol es necesario para poder crear Kajitas.

<img width="948" height="453" alt="image" src="https://github.com/user-attachments/assets/f5fc7170-20a0-4b60-a9e5-1f7d69dd5507" />

---

### 3. Crear Kajita desde la consola
Ruta: Configuración → Integraciones → Kajita → Crear nuevo formulario  
- Tipo: Pago Único.  
- Alias: "Technical Assessment".  
- Métodos de pago habilitados: tarjetas.
  - Se configuraron otros métodos de pago, pero para efecto de la prueba solo se trabajo con tarjetas.
- Campos activados: nombre y apellido, número de tarjeta, fecha de vencimiento, CVV, dirección de facturacción, teléfono,  email.
- Cambios de estilo:
  -  horientación - vertical.
  -  Detección automática de modo noche.
  -  Plantillas - underline.
  -  Colores del formulario - Color primario #6D96A4 - Color secundario #E7E9F2 - Errores #E24763.
  -  Forma del botón - redondo.
- Configuración de idioma en español y moneda en COP.
- Se incorporo la url para la recepción de token (Servidor publico)
  
<img width="458" height="791" alt="image" src="https://github.com/user-attachments/assets/043d4330-58bb-4eed-acc6-0e4e34a026b3" />

---

### 4. Embedding local de la Kajita
- Se generó el script de integración desde la consola.
- Se creó un archivo "index.html" con el snippet, scripts, y estructura html.
  
<img width="482" height="870" alt="7" src="https://github.com/user-attachments/assets/1fe8b032-36a9-42d6-8385-edeb79782e3c" />

---

### 4. Pruebas
- Se utilizo el hosting publico y servidor para recepción de token 
- Se usaron datos de tarjetas proporcionados en la documentación para simular el pago. 

<img width="1918" height="812" alt="9" src="https://github.com/user-attachments/assets/14eda954-d96a-4849-9373-bc309cd93b84" />

---

### Etapa II — Procesamiento API (resumen)

La etapa II consistió en consumir los endpoints de cargos, anulaciones y consultas de Kushki usando Postman, a partir del token generado en la etapa 1 donde se simulo un pago con Kajita.

Toda la evidencia se encuentra: 

- Documentación: docs/PROCESSING_API.md
- Requests/responses: postman/


- Herramienta: Postman (colección incluida en /postman/").
- **Flujo ejecutado:**
  1. Cargo (`POST /card/v1/charges`).
  2. Anulación (`DELETE /v1/charges/{ticketNumber}`).
  3. Consulta de transacciones (`POST /analytics/v2/transactions-list`).

---

