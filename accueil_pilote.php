<?php
require_once 'init.php';

// Données dynamiques à passer au template
$user = [
    'firstName' => 'Lukas',
];

// Rendre le template avec Twig
echo $twig->render('accueil_pilote.html.twig', [
    'user' => $user,
]);