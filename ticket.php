<?php
// 1. Vérification des permissions (DOIT être en tout premier)
require_once 'check_session.php';
checkPermission(2); // Permission admin requise

// 2. Initialisation Twig et autres require
require_once 'init.php';
require_once 'api_client.php'; // Inclure le fichier centralisé pour les appels API

// 3. URL de l'API pour récupérer les tickets
$apiUrl = 'https://web4all-api.alwaysdata.net/api/controller/ticket.php/tickets';

try {
    // Récupérer les données de l'API
    $tickets = fetchApiData($apiUrl);

    // Vérifier si aucun ticket n'est trouvé
    $noResultsMessage = '';
    if (empty($tickets)) {
        $noResultsMessage = 'Aucun ticket trouvé.';
    }

    // 4. Rendu (en dernier)
    echo $twig->render('ticket.html.twig', [
        'tickets' => $tickets,
        'user' => getUserInfo(),
        'noResultsMessage' => $noResultsMessage,
        'homePage' => $_SESSION['user']['homePage'] ?? 'connexion.php', // Par défaut, redirige vers la page de connexion
    ]);
} catch (Exception $e) {
    // Gérer les erreurs et afficher un message
    die('Erreur : ' . $e->getMessage());
}