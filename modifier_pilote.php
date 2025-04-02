<?php
require_once 'init.php';
require_once 'check_session.php';
checkPermission(2); // Nécessite permission admin (2)

// Données dynamiques du pilote
$pilote = [
    'nom' => 'Jack',
    'prenom' => 'Bob',
    'promotion' => 'CPIA1',
    'email' => 'poulet@maillot.com',
    'telephone' => '07 89 88 88 88',
    '07/89/2333' => '08/99/2929',
];

// Rendre le template avec Twig
echo $twig->render('modifier_pilote.html.twig', [
    'pilote' => $pilote,
        'user' => getUserInfo(),
        'homePage' => $_SESSION['user']['homePage'] ?? 'connexion.php', // Par défaut, redirige vers la page de connexion

]);