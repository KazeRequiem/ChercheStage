<?php
require_once 'check_session.php';
checkPermission(1); // Nécessite permission admin
require_once 'init.php';
require_once 'api_client.php'; // Inclure le fichier centralisé pour les appels API

// URL de l'API pour récupérer les entreprises
$apiUrl = 'https://web4all-api.alwaysdata.net/api/controller/entreprise.php/entreprises';

try {
    // Récupérer les données de l'API via la fonction centralisée
    $entreprises = fetchApiData($apiUrl);

    // Récupérer le paramètre de recherche
    $search = $_GET['search'] ?? '';

    // Filtrer les entreprises si une recherche est effectuée
    if (!empty($search)) {
        $entreprises = array_filter($entreprises, function ($entreprise) use ($search) {
            return stripos($entreprise['nom'], $search) !== false ||
                   stripos($entreprise['ville'], $search) !== false;
        });
    }

    // Vérifier si aucune entreprise n'est trouvée
    $noResultsMessage = '';
    if (empty($entreprises)) {
        $noResultsMessage = 'Aucune entreprise trouvée.';
    }

    // Débogage : Vérifier les données passées au template
    var_dump([
        'entreprises' => $entreprises,
        'user' => getUserInfo(),
        'search' => $search,
        'noResultsMessage' => $noResultsMessage,
    ]);
    exit();

    // Rendre le template avec Twig
    echo $twig->render('gestion_entreprise.html.twig', [
        'entreprises' => $entreprises,
        'user' => getUserInfo(),
        'search' => $search,
        'noResultsMessage' => $noResultsMessage,
        'homePage' => $_SESSION['user']['homePage'] ?? 'connexion.php', // Par défaut, redirige vers la page de connexion
    ]);
} catch (Exception $e) {
    // Gérer les erreurs et afficher un message
    die('Erreur : ' . $e->getMessage());
}