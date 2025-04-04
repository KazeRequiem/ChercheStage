<?php
require_once 'check_session.php';
checkPermission(1); // Nécessite permission admin (2)
require_once 'init.php';
require_once 'api_client.php'; // Inclure le fichier centralisé

// URL de l'API pour récupérer les offres
$apiUrl = 'https://web4all-api.alwaysdata.net/api/controller/offres.php/offres';

try {
    $apiUrl = 'https://web4all-api.alwaysdata.net/api/controller/offres.php/offres';

    // Récupérer les données de l'API
    $offres = fetchApiData($apiUrl);
    
    // Mapper les champs pour correspondre à ceux utilisés dans Twig
    $offres = array_map(function ($offre) {
        return [
            'id' => $offre['id_offre'],
            'title' => $offre['titre'],
            'description' => $offre['description'],
            'startDate' => $offre['date_debut'],
            'endDate' => $offre['date_fin'],
            'company' => 'Entreprise #' . $offre['id_entreprise'], // Exemple pour afficher une entreprise fictive
            'contractType' => $offre['type_contrat'],
            'salary' => $offre['salaire']
        ];
    }, $offres);
    
    // Récupérer le paramètre de recherche
    $search = $_GET['search'] ?? '';

    // Filtrer les offres si une recherche est effectuée
    if (!empty($search)) {
        $offres = array_filter($offres, function ($offre) use ($search) {
            return stripos($offre['title'], $search) !== false ||
                   stripos($offre['company'], $search) !== false;
        });
    }

    // Vérifier si aucune offre n'est trouvée
    $noResultsMessage = '';
    if (empty($offres)) {
        $noResultsMessage = 'Aucune offre trouvée.';
    }

    // Rendre le template avec Twig
    echo $twig->render('gestion_offre.html.twig', [
        'offres' => $offres,
        'search' => $search,
        'noResultsMessage' => $noResultsMessage,
        'user' => getUserInfo(),
        'homePage' => $_SESSION['user']['homePage'] ?? 'connexion.php', // Par défaut, redirige vers la page de connexion
    ]);
} catch (Exception $e) {
    // Gérer les erreurs et afficher un message
    die('Erreur : ' . $e->getMessage());
}