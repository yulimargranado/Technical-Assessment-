<?php

// Configuración Kushki (UAT)
$merchantId = getenv('KUSHKI_PRIVATE_MERCHANT_ID') ?: '2baadccc013e448cbb10487f92a18818'; 
$kushkiUrl = "https://api-uat.kushkipagos.com/card/v1/charges";

// Recibir token desde el formulario
$token = $_POST['token'] ?? null;
$amount = 1000; // Monto fijo de prueba

if (!$token) {
    die("<h2 style='color:red'> No se recibió token de la tarjeta</h2>");
}

// Payload
$payload = [
    "token" => $token,
    "amount" => [
        "subtotalIva" => 0,
        "subtotalIva0" =>  (int)$amount,
        "ice" => 0,
        "iva" => 0,
        "currency" => "COP"
        "total" => (int)$amount
    ],
    "metadata" => [
    "orderId" => "test-order-123"
    ],
    "fullResponse" => true
];

// Consumir API de Kushki
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $kushkiUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Private-Merchant-Id: $merchantId"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$curlErr = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($curlErr) {
    http_response_code(500);
    echo "<h2 style='color:red'>Error CURL: " . htmlspecialchars($curlErr) . "</h2>";
    exit;
}

// Decodificar respuesta
$data = json_decode($response, true);

// Mostrar resultado
if ($httpCode >= 200 && $httpCode < 300 && isset($data['ticketNumber'])) {
    echo "<h2 style='color:green'>Pago aprobado</h2>";
    echo "<p>Ticket: " . htmlspecialchars($data['ticketNumber']) . "</p>";
    echo "<pre>" . htmlspecialchars(json_encode($data, JSON_PRETTY_PRINT)) . "</pre>";
} else {
    http_response_code($httpCode ?: 400);
    $reason = $data['message'] ?? $data['error'] ?? 'Respuesta inválida del gateway';
    echo "<h2 style='color:red'>Pago rechazado</h2>";
    echo "<p>HTTP Code: $httpCode</p>";
    echo "<p>Motivo: " . htmlspecialchars($reason) . "</p>";
    echo "<pre>" . htmlspecialchars($response) . "</pre>";
}
?>



