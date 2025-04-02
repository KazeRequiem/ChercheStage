<?php
require_once 'init.php';

// Données des offres
$offres = [
    [
        'title' => 'Administrateur Systèmes & Réseaux',
        'company' => 'Thalès',
        'contractType' => 'CDI',
        'salary' => '~35k',
        'location' => 'Hénin-Beaumont',
        'logo' => 'assets/thales-logo.png',
        'editLink' => 'modifier_offre.php?id=1',
    ],
    [
        'title' => 'Développeur Full Stack',
        'company' => 'Dassault',
        'contractType' => 'CDD',
        'salary' => '~40k',
        'location' => 'Paris',
        'logo' => 'assets/dassault-logo.png',
        'editLink' => 'modifier_offre.php?id=2',
    ],
    [
        'title' => 'Ingénieur DevOps',
        'company' => 'Airbus',
        'contractType' => 'CDI',
        'salary' => '~50k',
        'location' => 'Toulouse',
        'logo' => 'assets/airbus-logo.png',
        'editLink' => 'modifier_offre.php?id=3',
    ],
];

// Récupérer le paramètre de recherche
$search = $_GET['search'] ?? '';

// Filtrer les offres si une recherche est effectuée
if (!empty($search)) {
    $offres = array_filter($offres, function ($offre) use ($search) {
        return stripos($offre['title'], $search) !== false ||
               stripos($offre['company'], $search) !== false ||
               stripos($offre['location'], $search) !== false;
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
]);