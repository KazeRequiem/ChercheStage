<?php
require_once 'init.php';
require_once 'check_session.php';
checkPermission(0); // Nécessite permission admin (2)

// Données des entreprises
$entreprises = [
    [
        'name' => 'Thales',
        'email' => 'thales@gmail.com',
        'rating' => 4.7,
        'phone' => '09 92 38 49 23',
        'candidates' => 6,
        'location' => 'Hénin-Beaumont',
        'logo' => 'assets/thales-logo.png',
        'link' => 'description_entreprise.php?id=1',
    ],
    [
        'name' => 'Dassault',
        'email' => 'dassault@gmail.com',
        'rating' => 4.5,
        'phone' => '01 23 45 67 89',
        'candidates' => 10,
        'location' => 'Paris',
        'logo' => 'assets/dassault-logo.png',
        'link' => 'description_entreprise.php?id=2',
    ],
    [
        'name' => 'Airbus',
        'email' => 'airbus@gmail.com',
        'rating' => 4.8,
        'phone' => '02 98 76 54 32',
        'candidates' => 15,
        'location' => 'Toulouse',
        'logo' => 'assets/airbus-logo.png',
        'link' => 'description_entreprise.php?id=3',
    ],
];

// Récupérer le paramètre de recherche
$search = $_GET['search'] ?? '';

// Filtrer les entreprises si une recherche est effectuée
if (!empty($search)) {
    $entreprises = array_filter($entreprises, function ($entreprise) use ($search) {
        return stripos($entreprise['name'], $search) !== false ||
               stripos($entreprise['location'], $search) !== false ||
               stripos($entreprise['email'], $search) !== false;
    });
}

// Vérifier si aucune entreprise n'est trouvée
$noResultsMessage = '';
if (empty($entreprises)) {
    $noResultsMessage = 'Aucune entreprise trouvée.';
}

// Rendre le template avec Twig
echo $twig->render('recherche_entreprise.html.twig', [
    'entreprises' => $entreprises,
    'user' => getUserInfo(),
    'search' => $search,
    'noResultsMessage' => $noResultsMessage,
]);