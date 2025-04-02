<?php
require_once 'init.php';
session_start();

// Vérification de la présence du PHPSESSID dans les cookies
if (!isset($_COOKIE['PHPSESSID'])) {
    die("Erreur : PHPSESSID non défini dans les cookies.");
}

$userId = $_SESSION['user']['id'] ?? 1; // Mettez un ID manuel si besoin
$apiUrl = "https://web4all-api.alwaysdata.net/api/controller/user.php/$userId";

var_dump($apiUrl);

// Initialisation de cURL
$ch = curl_init();

// Configuration des options cURL
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-type: application/json"
]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Désactiver la vérification SSL si nécessaire

// Définir le cookie à envoyer avec la requête
curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID=' . $_COOKIE['PHPSESSID']);

// Exécution de la requête cURL
$response = curl_exec($ch);

// Vérification des erreurs
if (curl_errno($ch)) {
    echo 'Erreur cURL : ' . curl_error($ch);
} else {
    // Traitement de la réponse
    echo "Réponse de l'API : " . $response;

    // Affichage des données décodées pour le débogage
    $data = json_decode($response, true);
    echo "<h1>Données décodées</h1>";
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

// Fermeture de la session cURL
curl_close($ch);

// Affichage de la session utilisateur pour le débogage
echo "<h1>Session utilisateur</h1>";
echo "<pre>";
print_r($_SESSION['user']);
echo "</pre>";
?>
