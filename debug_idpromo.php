<?php
require_once 'check_session.php';
checkPermission(1); // Vérifie que c'est un pilote
require_once 'init.php';

// Vérification de la présence du PHPSESSID dans les cookies
if (!isset($_COOKIE['PHPSESSID'])) {
    die("Erreur : PHPSESSID non défini dans les cookies.");
}

$userId = $_SESSION['user']['id'];
$apiUrl = "https://web4all-api.alwaysdata.net/api/controller/user.php/$userId";

// Initialisation de cURL pour récupérer les données de l'utilisateur
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
    $apiData = json_decode($response, true);

    // Debug: afficher les données brutes de l'utilisateur
    echo "<pre>Données Utilisateur: ";
    print_r($apiData);
    echo "</pre>";

    // Récupérer les IDs des promotions
    $promotionIds = $apiData['promotions'] ?? [];
    $promotionNames = [];

    // Initialisation de cURL pour récupérer les noms des promotions
    foreach ($promotionIds as $promotionId) {
        $promotionApiUrl = "https://web4all-api.alwaysdata.net/api/controller/promotion.php/$promotionId";

        // Configuration des options cURL pour la promotion
        curl_setopt($ch, CURLOPT_URL, $promotionApiUrl);

        // Exécution de la requête cURL
        $promotionResponse = curl_exec($ch);

        // Vérification des erreurs
        if (curl_errno($ch)) {
            echo 'Erreur cURL pour la promotion ID ' . $promotionId . ' : ' . curl_error($ch);
        } else {
            // Traitement de la réponse
            $promotionData = json_decode($promotionResponse, true);

            // Debug: afficher les données brutes de la promotion
            echo "<pre>Données Promotion ID $promotionId: ";
            print_r($promotionData);
            echo "</pre>";

            $promotionNames[] = $promotionData['nom'] ?? 'Nom non défini';
        }
    }

    // Construction du profil
    $pilot = [
        'lastName' => $apiData['nom'] ?? $_SESSION['user']['nom'] ?? 'Nom non défini',
        'firstName' => $apiData['prenom'] ?? $_SESSION['user']['prenom'] ?? 'Prénom non défini',
        'email' => $apiData['email'] ?? $_SESSION['user']['email'] ?? 'Email non défini',
        'school' => 'Arras', // À remplacer par $apiData['school'] si disponible
        'promotions' => $promotionNames
    ];

    echo $twig->render('profil_pilote.html.twig', [
        'pilot' => $pilot,
        'user' => $_SESSION['user'] // Passer les données de session au template
    ]);
}

// Fermeture de la session cURL
curl_close($ch);
?>
