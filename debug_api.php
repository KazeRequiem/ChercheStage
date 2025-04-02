<?php
require_once 'init.php';
session_start();

$userId = $_SESSION['user']['id'] ?? 1; // Mettez un ID manuel si besoin
$apiUrl = "https://web4all-api.alwaysdata.net/api/controller/user.php/$userId";

var_dump($apiUrl);

$options = [
    'http' => [
        'header' => "Content-type: application/json",
        'method' => 'GET'
    ]
];

$ch = curl_init();

// URL de la requête
$url = "https://api.example.com/data";

// Configuration des options de la requête
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
// Définir le cookie à envoyer avec la requête
curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID=b5163047e130221efbacde7984ffd283');

// Exécution de la requête cURL
$response = curl_exec($ch);

// Vérification des erreurs
if(curl_errno($ch)) {
    echo 'Erreur cURL : ' . curl_error($ch);
} else {
    // Traitement de la réponse
    echo "Réponse de l'API : " . $response;
}

// Fermeture de la session cURL
curl_close($ch);

// $context = stream_context_create($options);
// $response = file_get_contents($apiUrl, false, $context);

// echo "<h1>Réponse brute de l'API</h1>";
// echo "<pre>".htmlspecialchars($response)."</pre>";

// $data = json_decode($response, true);
// echo "<h1>Données décodées</h1>";
// echo "<pre>";
// print_r($data);
// echo "</pre>";

// echo "<h1>Session utilisateur</h1>";
// echo "<pre>";
// print_r($_SESSION['user']);
// echo "</pre>";