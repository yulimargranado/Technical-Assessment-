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
- Se confirmó que el usuario tiene rol **Usuario Maestro**.  
- Este rol es necesario para poder crear Kajitas.

📸 **Evidencia:** `screenshots/roles.png`

---

### 3. Crear Kajita desde la consola
Ruta: **Configuración → Integraciones → Kajita → Crear nuevo formulario**  
- Tipo: Pago Único.  
- Alias: `kajita-uat-prueba-Yuli`.  
- Métodos de pago habilitados: tarjetas.  
- Campos activados: nombre, email, número de tarjeta, fecha, CVV.  
- Configuración de idioma y moneda en **USD**.

📸 **Evidencia:** `screenshots/kajita_create.png`

---

### 4. Embedding local de la Kajita
- Se generó el script de integración desde la consola.
- Se creó un archivo `index.html` con el snippet:

```html
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Kajita UAT Test</title>
</head>
<body>
  <div id="kajita-container"></div>
  <!-- Script provisto por la consola UAT -->
  <script src="https://uat.kushkipagos.com/kajita.js"
          kushki-key="PUBLIC_KEY_REDACTED"
          kushki-merchant-id="MERCHANT_ID_REDACTED"
          data-form="kajita-uat-prueba-Yuli">
  </script>
</body>
</html>
