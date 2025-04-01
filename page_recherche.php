<?php
require_once 'init.php';

// Données dynamiques pour les offres
$offers = [
    [
        'title' => 'Administrateur Systèmes & Réseaux',
        'company' => 'Thalès',
        'contractType' => 'CDI',
        'salary' => '~35k',
        'location' => 'Hénin-Beaumont',
        'logo' => 'thales-logo.png',
    ],
    [
        'title' => 'Développeur Full Stack',
        'company' => 'Airbus',
        'contractType' => 'CDD',
        'salary' => '~40k',
        'location' => 'Toulouse',
        'logo' => 'airbus-logo.png',
    ],
    [
        'title' => 'Chef de Projet IT',
        'company' => 'Safran',
        'contractType' => 'CDI',
        'salary' => '~50k',
        'location' => 'Paris',
        'logo' => 'safran-logo.png',
    ],
];

// Rendre le template avec Twig
echo $twig->render('page_recherche.html.twig', [
    'offers' => $offers,
]);