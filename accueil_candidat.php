<?php
require_once 'check_session.php';
checkRole(0); // Nécessite au moins candidat (0)
require_once 'init.php';


// Données pour le graphique des pilotes
$chartDataCandidat = [
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
        'legend' => ['position' => 'bottom'],
        'title' => ['display' => false], // Pas de titre dans le graphique
    ],
];

// Rendre le template avec Twig
echo $twig->render('accueil_candidat.html.twig', [
    'user' => getUserInfo(),
    'chartDataCandidat' => $chartDataCandidat,
    'chartOptions' => $chartOptions,
    'homePage' => $_SESSION['user']['homePage'] ?? 'connexion.php', // Par défaut, redirige vers la page de connexion

]);