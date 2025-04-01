<?php
require_once 'init.php';

// Données dynamiques pour les candidatures envoyées et reçues
$candidaturesEnvoyees = [
    [
        'title' => 'Dassault',
        'location' => 'Maubeuge',
        'date' => '22/11/24',
        'status' => 'En attente',
        'statusClass' => 'en-attente',
        'viewLink' => true,
    ],
];

$candidaturesRecues = [
    [
        'title' => 'Dassault',
        'location' => 'Maubeuge',
        'date' => '22/11/24',
        'viewLink' => true,
    ],
    [
        'title' => 'Dassault',
        'location' => 'Maubeuge',
        'date' => '22/11/24',
        'viewLink' => true,
    ],
];

// Rendre le template avec Twig
echo $twig->render('candidatures_envoyees.html.twig', [
    'candidaturesEnvoyees' => $candidaturesEnvoyees,
    'candidaturesRecues' => $candidaturesRecues,
]);