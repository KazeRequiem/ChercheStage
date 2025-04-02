<?php
require_once 'init.php';
require_once 'check_session.php';
checkPermission(0); // Nécessite permission admin (2)

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
        'user' => getUserInfo(),
        'homePage' => $_SESSION['user']['homePage'] ?? 'connexion.php', // Par défaut, redirige vers la page de connexion

]);