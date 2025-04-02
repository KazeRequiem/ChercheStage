<?php
require_once 'init.php';
require_once 'check_session.php';
checkPermission(2); // Nécessite permission admin (2)

// Données pour les graphiques circulaires
$chartDataCandidat = [
    'labels' => ['Admis', 'En attente', 'Refusés'],
    'datasets' => [
        [
            'label' => 'Répartition des candidats',
            'data' => [50, 30, 20],
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

$chartDataEntreprise = [
    'labels' => ['Partenaires', 'Non partenaires'],
    'datasets' => [
        [
            'label' => 'Répartition des entreprises',
            'data' => [70, 30],
            'backgroundColor' => [
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 159, 64, 0.6)',
            ],
            'borderColor' => [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 159, 64, 1)',
            ],
            'borderWidth' => 1,
        ],
    ],
];

$chartDataPilote = [
    'labels' => ['Actifs', 'Inactifs'],
    'datasets' => [
        [
            'label' => 'Répartition des pilotes',
            'data' => [80, 20],
            'backgroundColor' => [
                'rgba(153, 102, 255, 0.6)',
                'rgba(255, 205, 86, 0.6)',
            ],
            'borderColor' => [
                'rgba(153, 102, 255, 1)',
                'rgba(255, 205, 86, 1)',
            ],
            'borderWidth' => 1,
        ],
    ],
];

$chartOptions = [
    'responsive' => true,
    'plugins' => [
        'legend' => ['position' => 'bottom'],
        'title' => ['display' => true, 'text' => 'Statistiques Globales'],
    ],
];

// Rendre le template avec Twig
echo $twig->render('statistique_global.html.twig', [
    'chartDataCandidat' => $chartDataCandidat,
    'chartDataEntreprise' => $chartDataEntreprise,
    'chartDataPilote' => $chartDataPilote,
    'chartOptions' => $chartOptions,
    'user' => getUserInfo(),
    'homePage' => $_SESSION['user']['homePage'] ?? 'connexion.php', // Par défaut, redirige vers la page de connexion

]);