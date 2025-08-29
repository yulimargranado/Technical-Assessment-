<?php

<?php

// Configuración Kushki (UAT)
$merchantId = "2baadccc013e448cbb10487f92a18818"; 
$kushkiUrl  = "https://api-uat.kushkipagos.com/card/v1/charges";

// Recibir token desde el formulario
$token  = $_POST['token'] ?? null;
$amount = 1000; // Monto fijo de prueba

if (!$token) {
    http_response_code(400);
    die("<h2 style='color:red'> No se recibió token de la tarjeta</h2>");
}

// Payload
$payload = [
    "token"  => $token,
    "amount" => [
        "subtotalIva"  => 0,
        "subtotalIva0" => $amount,
        "ice"          => 0,
        "iva"          => 0,
        "currency"     => "COP",
        "total"        => $amount
    ],
    "metadata"     => [
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

$response = curl_exec($ch);
$curlErr  = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Manejo de errores de red
if ($curlErr) {
    http_response_code(500);
    echo "<h2 style='color:red'>Error CURL</h2>";
    echo "<pre>$curlErr</pre>";
    exit;
}

// Decodificar respuesta
$data = json_decode($response, true);

// Mostrar resultado
if ($httpCode >= 200 && $httpCode < 300 && isset($data['ticketNumber'])) {
    echo "<h2 style='color:green'>Pago aprobado</h2>";
    echo "<p>Ticket: " . htmlspecialchars($data['ticketNumber']) . "</p>";
    echo "<pre>" . htmlspecialchars(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) . "</pre>";
} else {
    http_response_code($httpCode ?: 400);
    $reason = $data['message'] ?? $data['error'] ?? 'Respuesta inválida del gateway';
    echo "<h2 style='color:red'>Pago rechazado</h2>";
    echo "<p>HTTP Code: $httpCode</p>";
    echo "<p>Motivo: " . htmlspecialchars($reason) . "</p>";
    echo "<pre>" . htmlspecialchars($response) . "</pre>";
}
?>




