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

// Rendre le template avec Twig
echo $twig->render('gestion_offre.html.twig', [
    'offres' => $offres,
]);