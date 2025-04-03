<?php
require_once 'init.php';
require_once 'check_session.php';
checkPermission(0); // Nécessite permission utilisateur (0)

// Vérifier si l'ID de l'offre est fourni dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Erreur : ID de l\'offre manquant.');
}

$offreId = $_GET['id'];
$apiUrl = "https://web4all-api.alwaysdata.net/api/controller/offres.php/offre/$offreId";

try {
    // Vérifier si le cookie de session existe
    if (!isset($_COOKIE['PHPSESSID'])) {
        throw new Exception('Session non valide. Veuillez vous reconnecter.');
    }

    // Récupérer les données de l'offre via l'API
    $ch = curl_init($apiUrl);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false, // Désactiver la vérification SSL
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Accept: application/json',
        ],
        CURLOPT_COOKIE => 'PHPSESSID=' . $_COOKIE['PHPSESSID'], // Transmettre le cookie de session
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        throw new Exception('Erreur cURL : ' . curl_error($ch));
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200 && $httpCode !== 201) {
        throw new Exception("Erreur API : Code HTTP $httpCode");
    }

    $offer = json_decode($response, true);

    var_dump($offer); // Debug: Afficher la réponse de l'API

    if (!$offer || !isset($offer['id_offre'])) {
        throw new Exception('Impossible de récupérer les données de l\'offre.');
    }

    // Rendre le template avec Twig
    echo $twig->render('offre_emploi.html.twig', [
        'offer' => $offer,
        'user' => getUserInfo(),
        'homePage' => $_SESSION['user']['homePage'] ?? 'connexion.php', // Par défaut, redirige vers la page de connexion
    ]);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}