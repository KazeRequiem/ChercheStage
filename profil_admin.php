<?php
require_once 'check_session.php';
checkPermission(2); // Vérifie que c'est un admin
require_once 'init.php';

// Vérification de la présence du PHPSESSID dans les cookies
if (!isset($_COOKIE['PHPSESSID'])) {
    die("Erreur : PHPSESSID non défini dans les cookies.");
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
curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID=' . $_COOKIE['PHPSESSID']);

// Exécution de la requête cURL
$response = curl_exec($ch);

// Vérification des erreurs
if (curl_errno($ch)) {
    echo 'Erreur cURL : ' . curl_error($ch);
} else {
    // Traitement de la réponse
    $apiData = json_decode($response, true);

    // Construction du profil
    $profile = [
        'nom' => $apiData['nom'] ?? $_SESSION['user']['nom'] ?? 'Non renseigné',
        'prenom' => $apiData['prenom'] ?? $_SESSION['user']['prenom'] ?? 'Non renseigné',
        'email' => $apiData['email'] ?? $_SESSION['user']['email'] ?? 'Non renseigné',
        'tel' => $apiData['telephone'] ?? $apiData['tel'] ?? 'Non renseigné',
        'date_naissance' => $apiData['date_naissance'] ?? 'Non renseignée',
        'permission' => $_SESSION['user']['permission'] ?? 'Non renseignée',
        'id_promotion' => $apiData['id_promotion'] ?? 'Non renseigné',
        'role' => 'Administrateur'
    ];

    echo $twig->render('profil_admin.html.twig', [
        'admin' => $profile
    ]);
}

// Fermeture de la session cURL
curl_close($ch);
?>
