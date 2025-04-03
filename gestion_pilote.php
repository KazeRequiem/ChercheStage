<?php
require_once 'check_session.php';
checkPermission(1); // Nécessite permission admin (2)
require_once 'init.php';
require_once 'api_client.php'; // Inclure le fichier centralisé

// URL de l'API pour récupérer les utilisateurs
$apiUrl = 'https://web4all-api.alwaysdata.net/api/controller/user.php/users';

try {
    // Récupérer les données de l'API
    $users = fetchApiData($apiUrl);

    // Filtrer pour ne garder que les pilotes (permission: 1)
    $pilotes = array_filter($users, function ($user) {
        return isset($user['permission']) && $user['permission'] === 1;
    });

    // Récupérer le paramètre de recherche
    $search = $_GET['search'] ?? '';

    // Filtrer les pilotes si une recherche est effectuée
    if (!empty($search)) {
        $pilotes = array_filter($pilotes, function ($pilote) use ($search) {
            return stripos($pilote['prenom'], $search) !== false ||
                   stripos($pilote['nom'], $search) !== false;
        });
    }

    // Vérifier si aucun pilote n'est trouvé
    $noResultsMessage = '';
    if (empty($pilotes)) {
        $noResultsMessage = 'Aucun pilote trouvé.';
    }

    // Rendre le template avec Twig
    echo $twig->render('gestion_pilote.html.twig', [
        'pilotes' => $pilotes,
        'user' => getUserInfo(),
        'search' => $search,
        'noResultsMessage' => $noResultsMessage,
        'homePage' => $_SESSION['user']['homePage'] ?? 'connexion.php', // Par défaut, redirige vers la page de connexion

    ]);
} catch (Exception $e) {
    // Gérer les erreurs et afficher un message
    die('Erreur : ' . $e->getMessage());
}