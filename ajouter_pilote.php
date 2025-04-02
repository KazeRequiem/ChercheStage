<?php
require_once 'init.php';
require_once 'check_session.php';
checkPermission(2); // Nécessite permission admin (2)

// Données dynamiques à passer au template
$user = [
    'firstName' => 'Admin',
];

// Rendre le template avec Twig
echo $twig->render('ajouter_pilote.html.twig', [
        'user' => getUserInfo(),
]);