<?php
// 1. Vérification des permissions (DOIT être en tout premier)
require_once 'check_session.php';
checkPermission(2); // Permission admin requise

// 2. Initialisation Twig et autres require
require_once 'init.php';

// 3. Données dynamiques
$tickets = [
    [
        'id' => 1,
        'demandeur' => 'Jean Dupont',
        'titre' => 'Problème de connexion',
        'dateCreation' => '2025-03-30',
        'etat' => 'Non résolu',
        'action' => 'Marquer comme résolu',
    ],
    // ...
];

// 4. Rendu (en dernier)
echo $twig->render('ticket.html.twig', [
    'tickets' => $tickets,
    'user' => getUserInfo(),
    'homePage' => $_SESSION['user']['homePage'] ?? 'connexion.php', // Par défaut, redirige vers la page de connexion

]);