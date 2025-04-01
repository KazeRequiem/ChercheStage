<?php
require_once 'init.php';

// Données dynamiques à passer au template
$user = [
    'firstName' => 'Jason statam',
];

$offers = [
    [
        'id' => 1,
        'title' => 'Danceuse etoile',
        'company' => 'Thalès',
        'contractType' => 'CDI',
        'salary' => '~35k',
        'location' => 'Hénin-Beaumont',
        'logo' => 'thales-logo.png',
    ],

    [
        'id' => 2,
        'title' => 'kebabier',
        'company' => 'Thalès',
        'contractType' => 'CDI',
        'salary' => '~35k',
        'location' => 'Hénin-Beaumont',
        'logo' => 'thales-logo.png',
    ],
    // Ajoutez d'autres offres ici
];

// Rendre le template avec Twig
echo $twig->render('accueil_candidat.html.twig', [
    'user' => $user,
    'offers' => $offers,
]);