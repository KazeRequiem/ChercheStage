<?php
require_once 'init.php';

// Données dynamiques pour les favoris et les recherches enregistrées
$favoris = [
    [
        'title' => 'Administrateur Systèmes & Réseaux',
        'location' => 'Hénin-Beaumont',
        'contractType' => 'CDI',
        'salary' => '~35k',
        'logo' => 'thales-logo.png',
    ],
];

$recherches = [
    [
        'title' => 'Assistant marchand de glace h/f',
        'location' => 'Maubeuge',
        'contractType' => 'CDI',
        'remote' => 'Télétravail partiel',
    ],
];

// Rendre le template avec Twig
echo $twig->render('candidatures_favoris.html.twig', [
    'favoris' => $favoris,
    'recherches' => $recherches,
]);