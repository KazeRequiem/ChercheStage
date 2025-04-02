<?php
require_once 'check_session.php';
checkPermission(1); // Nécessite permission admin (2)
require_once 'init.php';

// Données dynamiques pour les entreprises
$companies = [
    [
        'name' => 'Thales',
        'location' => 'Hénin-Beaumont',
        'email' => 'thales@gmail.com',
        'phone' => '07 43 54 32 43',
        'logo' => 'thales-logo.png',
    ],
    [
        'name' => 'Airbus',
        'location' => 'Toulouse',
        'email' => 'airbus@gmail.com',
        'phone' => '06 12 34 56 78',
        'logo' => 'airbus-logo.png',
    ],
    [
        'name' => 'Safran',
        'location' => 'Paris',
        'email' => 'safran@gmail.com',
        'phone' => '05 67 89 01 23',
        'logo' => 'safran-logo.png',
    ],
];

// Récupérer le paramètre de recherche
$search = $_GET['search'] ?? '';

// Filtrer les entreprises si une recherche est effectuée
if (!empty($search)) {
    $companies = array_filter($companies, function ($company) use ($search) {
        return stripos($company['name'], $search) !== false;
    });
}

// Vérifier si aucune entreprise n'est trouvée
$noResultsMessage = '';
if (empty($companies)) {
    $noResultsMessage = 'Aucune entreprise trouvée.';
}

// Rendre le template avec Twig
echo $twig->render('gestion_entreprise.html.twig', [
    'companies' => $companies,
    'search' => $search,
    'noResultsMessage' => $noResultsMessage,
    'homePage' => $_SESSION['user']['homePage'] ?? 'connexion.php', // Par défaut, redirige vers la page de connexion

]);