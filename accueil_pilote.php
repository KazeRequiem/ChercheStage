<?php
require_once 'check_session.php';
checkRole(1); // Nécessite au moins pilote (1)
require_once 'init.php';



// Données pour le graphique des pilotes
$chartDataPilote = [
    'labels' => ['Actifs', 'Inactifs'],
    'datasets' => [
        [
            'label' => 'Répartition des pilotes',
            'data' => [70, 30], // Exemple : 70 actifs, 30 inactifs
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

$chartOptions = [
    'responsive' => true,
    'plugins' => [
        'legend' => ['position' => 'top'],
        'title' => ['display' => false], // Pas de titre dans le graphique
    ],
];

// Données utilisateur
$user = [
    'firstName' => 'Lukas',
];

// Rendre le template avec Twig
echo $twig->render('accueil_pilote.html.twig', [
    'chartDataPilote' => $chartDataPilote,
    'chartOptions' => $chartOptions,
    'user' => getUserInfo(),
    'homePage' => $_SESSION['user']['homePage'] ?? 'connexion.php', // Par défaut, redirige vers la page de connexion

]);