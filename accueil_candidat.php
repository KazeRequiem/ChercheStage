<?php
require_once 'init.php';

// Données pour le graphique
$chartDataCandidat = [
    'labels' => ['Admis', 'En attente', 'Refusés'],
    'datasets' => [
        [
            'label' => 'Répartition des candidats',
            'data' => [50, 30, 20], // Exemple : 50 admis, 30 en attente, 20 refusés
            'backgroundColor' => [
                'rgba(75, 192, 192, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(255, 99, 132, 0.6)',
            ],
            'borderColor' => [
                'rgba(75, 192, 192, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)',
            ],
            'borderWidth' => 1,
        ],
    ],
];

$chartOptions = [
    'responsive' => true,
    'plugins' => [
        'legend' => ['position' => 'bottom'],
    ],
];

// Données utilisateur
$user = [
    'firstName' => 'Jean',
];

// Données des offres
$offers = [
    [
        'title' => 'Administrateur Systèmes & Réseaux',
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
    'chartDataCandidat' => $chartDataCandidat,
    'chartOptions' => $chartOptions,
    'offers' => $offers,
]);