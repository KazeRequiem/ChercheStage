<?php
require_once 'init.php';
require_once 'check_session.php';
checkPermission(2); // Nécessite permission admin (2)

// Données dynamiques du pilote
$pilote = [
    'nom' => 'Jack',
    'prenom' => 'Bob',
    'etablissement' => 'Maubeuge',
    'email' => 'poulet@maillot.com',
];

// Rendre le template avec Twig
echo $twig->render('modifier_pilote.html.twig', [
    'pilote' => $pilote,
        'user' => getUserInfo(),
]);