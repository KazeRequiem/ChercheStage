<?php
require_once 'check_session.php';
checkPermission(2); // Vérifie que c'est un admin
require_once 'init.php';

session_start();

// Affichage des variables de session pour le débogage
echo "<pre>Session: ";
var_dump($_COOKIE);
echo "</pre>";

// Vérification de la présence du PHPSESSID dans la session
if (!isset($_SESSION['phpsessid'])) {
    die("Erreur : PHPSESSID non défini dans la session.");
}

$userId = $_SESSION['user']['id'];
$apiUrl = "https://web4all-api.alwaysdata.net/api/controller/user.php/$userId";

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
curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID=' . $_SESSION['phpsessid']);

// Exécution de la requête cURL
$response = curl_exec($ch);

// Vérification des erreurs
if (curl_errno($ch)) {
    echo 'Erreur cURL : ' . curl_error($ch);
} else {
    // Traitement de la réponse
    $apiData = json_decode($response, true);

    // Debug: afficher les données brutes (à supprimer en production)
    echo "<pre>Données API: ";
    print_r($apiData);
    echo "</pre>";

    // Construction du profil
    $profile = [
        'nom' => $apiData['nom'] ?? $_SESSION['user']['nom'] ?? 'Non renseigné',
        'prenom' => $apiData['prenom'] ?? $_SESSION['user']['prenom'] ?? 'Non renseigné',
        'email' => $apiData['email'] ?? $_SESSION['user']['email'] ?? 'Non renseigné',
        'tel' => $apiData['telephone'] ?? $apiData['tel'] ?? 'Non renseigné',
        'ville' => $apiData['ville'] ?? $apiData['city'] ?? 'Non renseignée',
        'code_postal' => $apiData['code_postal'] ?? $apiData['zip'] ?? 'Non renseigné',
        'region' => $apiData['region'] ?? $apiData['state'] ?? 'Non renseignée',
        'pays' => $apiData['pays'] ?? $apiData['country'] ?? 'Non renseigné',
        'role' => 'Administrateur'
    ];

    echo $twig->render('profil_admin.html.twig', [
        'user' => $profile
    ]);
}

// Fermeture de la session cURL
curl_close($ch);
?>
