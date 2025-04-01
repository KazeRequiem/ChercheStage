<?php
require_once 'init.php';

// Données pour les candidatures envoyées
$candidatures_envoyees = [
    [
        'company' => 'Dassault',
        'location' => 'Maubeuge',
        'date' => '22/11/24',
        'position' => 'Administrateur Systèmes Réseaux',
        'status' => 'En attente',
        'status_class' => 'en-attente',
    ],
];

// Données pour les candidatures reçues
$candidatures_recues = [
    [
        'company' => 'Dassault',
        'location' => 'Maubeuge',
        'date' => '22/11/24',
    ],
    [
        'company' => 'Dassault',
        'location' => 'Maubeuge',
        'date' => '22/11/24',
    ],
];

// Rendre le template avec Twig
echo $twig->render('candidatures_envoyees.html.twig', [
    'candidatures_envoyees' => $candidatures_envoyees,
    'candidatures_recues' => $candidatures_recues,
]);