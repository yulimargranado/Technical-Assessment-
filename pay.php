<?php

// Configuración Kushki (UAT)
$merchantId = "2baadccc013e448cbb10487f92a18818"; 
$kushkiUrl = "https://api-uat.kushkipagos.com/card/v1/charges";

// Recibir token desde el formulario
$token = $_POST['token'] ?? null;
$amount = 1000; // Monto fijo de prueba

if (!$token) {
    die("<h2 style='color:red'> No se recibió token de la tarjeta</h2>");
}

// Payload
$payload = [
    "amount" => [
        "subtotalIva" => 0,
        "subtotalIva0" => $amount,
        "ice" => 0,
        "iva" => 0,
        "currency" => "COP"
    ],
    "token" => $token,
    "metadata" => [
        "orderId" => "test-order-123"
    ]
];

// Consumir API de Kushki
$ch = curl_init($kushkiUrl);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Private-Merchant-Id: $merchantId"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

$response = curl_exec($ch);
curl_close($ch);

// Decodificar respuesta
$data = json_decode($response, true);

// Mostrar resultado
if (isset($data['ticketNumber'])) {
    echo "<h2 style='color:green'>Pago aprobado</h2>";
    echo "<p>Ticket: " . htmlspecialchars($data['ticketNumber']) . "</p>";
} else {
    echo "<h2 style='color:red'>Pago rechazado</h2>";
    echo "<p>Motivo: " . htmlspecialchars($data['message'] ?? 'Error desconocido') . "</p>";
}
?>


