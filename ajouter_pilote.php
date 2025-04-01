<?php
require_once 'init.php';

// Données dynamiques à passer au template
$user = [
    'firstName' => 'Admin',
];

// Rendre le template avec Twig
echo $twig->render('ajouter_pilote.html.twig', [
    'user' => $user,
]);