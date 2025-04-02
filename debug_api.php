<?php
require_once 'init.php';
session_start();

$userId = $_SESSION['user']['id'] ?? 1; // Mettez un ID manuel si besoin
$apiUrl = "https://web4all-api.alwaysdata.net/api/controller/user.php/$userId";

$options = [
    'http' => [
        'header' => "Content-type: application/json",
        'method' => 'GET'
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($apiUrl, false, $context);

echo "<h1>Réponse brute de l'API</h1>";
echo "<pre>".htmlspecialchars($response)."</pre>";

$data = json_decode($response, true);
echo "<h1>Données décodées</h1>";
echo "<pre>";
print_r($data);
echo "</pre>";

echo "<h1>Session utilisateur</h1>";
echo "<pre>";
print_r($_SESSION['user']);
echo "</pre>";